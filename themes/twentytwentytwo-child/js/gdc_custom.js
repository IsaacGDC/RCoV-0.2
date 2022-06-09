
function startParallaxObserver() {
  const maxPixelsToMove = 300
  const pixelsToMove = 2
  let pixelCount = 0;
  let scrollDirection;  
  let oldValue = 0
  let newValue = 0
  
  window.addEventListener('scroll', (e) => {
    newValue = window.pageYOffset;
    if (oldValue < newValue) {
      scrollDirection = 'up'
    } else if (oldValue > newValue) {
      scrollDirection = 'down'
    }
    oldValue = newValue;
  });

  function createObserver() {
    const parallaxElements = document.querySelectorAll('.gdc-animation-parallax');
    let observer;
  
    let options = {
      root: null,
      rootMargin: "0px",
      threshold: buildThresholdList()
    };
  
    observer = new IntersectionObserver(handleIntersect, options);
    parallaxElements.forEach((element) => observer.observe(element))
  }

  function buildThresholdList() {
    let thresholds = [];
    let numSteps = 100;
  
    for (let i=1.0; i<=numSteps; i++) {
      let ratio = i/numSteps;
      thresholds.push(ratio);
    }
  
    thresholds.push(0);
    return thresholds;
  }

  function handleIntersect(entries, observer) {
    
    entries.forEach((entry) => { 
      if (entry.isIntersecting) {
        if (scrollDirection === 'down') {
          parallaxUp(entry) 
        }
        if (scrollDirection === 'up') {
          parallaxDown(entry)
        }
      }
    });
  }

  function parallaxDown(entry) {
    if (pixelCount > -maxPixelsToMove) {
      pixelCount = pixelCount - pixelsToMove
      translateY(entry, pixelCount)
    }
  }

  function parallaxUp(entry) {
    if (pixelCount < 0) {
      pixelCount = pixelCount + pixelsToMove
      translateY(entry, pixelCount)
    }
  }

  function translateY(elem, pixels) {
    elem.target.style.transform = `translateY(${pixels}px)`
  }

  createObserver()
}

function startGalleryObserver() {
  const state = {
    galleries: document.querySelectorAll('.gdc-gallery-sticky-text'),
    currentGallery: '',
    observerOptions: {
      root: null, 
      rootMargin: '0px', 
      threshold: [0,0.2,0.8,1] 
    }
  }
  
  let galleryObserver = new IntersectionObserver(onGalleryChange, state.observerOptions);

  state.galleries.forEach((gallery) => {
    setGalleryDots(gallery)
    galleryObserver.observe(gallery)
  })

  function setGalleryDots(gallery) {
    const galleryTextGroups = gallery.querySelectorAll('.gdc-gallery-sticky-text__text-group')
    const galleryDotsDiv = gallery.querySelector('.gdc-slider-dots')

    galleryTextGroups.forEach((textGroup, groupIndex) => { 
      const newDot = `<div class="gdc-slider-dot" data-dot-index="${groupIndex + 1}"></div>`

      galleryDotsDiv.insertAdjacentHTML("beforeend", newDot);
    })
  }

  function onGalleryChange(changes) {
    changes.forEach(change => {
      if (change.isIntersecting) {
        let gallery = change.target
        handleGallery(gallery)
      }
    });
  }

  function handleGallery(gallery) {
    state.currentGallery = gallery;

    const galleryTextGroups = gallery.querySelectorAll('.gdc-gallery-sticky-text__text-group')

    let options = {
      root: null, 
      rootMargin: '0px', 
      threshold: 1 
    };

    let textObserver = new IntersectionObserver(onTextGroupChange, options);

    galleryTextGroups.forEach((textGroup, groupIndex) => { 
      textGroup.setAttribute('data-group-index', groupIndex + 1)
      textObserver.observe(textGroup, gallery)
    })
  }

  function activateCurrentGalleryDot(change) {
    let dot = change.target
    const galleryDots = state.currentGallery.querySelectorAll('.gdc-slider-dot')
    const currentIndex = dot.dataset.groupIndex;

    galleryDots.forEach(dot => {
      dot.classList.remove('gdc-slider-dot--active')
      if (dot.dataset.dotIndex == currentIndex) {
        dot.classList.add('gdc-slider-dot--active')
      }
    })
  }

  function onTextGroupChange(changes) {
    changes.forEach(change => {
      if (change.isIntersecting) {
        activateCurrentGalleryDot(change)
      }
    });
  }
}

window.addEventListener('load', () => {
  startParallaxObserver()
  startGalleryObserver()
});
