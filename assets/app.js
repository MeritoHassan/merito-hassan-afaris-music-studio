import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.scss';

document.addEventListener('turbo:load', () => {

    const resizeObserver = new ResizeObserver((entries) => {
        for (const entry of entries) {
            const width = entry.borderBoxSize[0].inlineSize;
            if(width <= 1920 && width >= 1051){
                screenSize(width);
            }
        }
    });

    // Body or HTML but not css margin padding ... just full screen!!
    resizeObserver.observe(document.querySelector('body'), {box: 'border-box'});
});

const screenSize = width => {
    console.log(`Width screeSize: ${width}px`);
    const sizeInfo = sizeInformation(width);
    updateDimensions(sizeInfo);
}

const updateDimensions = informationBreadPoint => {
    const images = document.querySelectorAll('.perspective img');

    images.forEach(img => {
        const parent = img.closest(".perspective");
        parent.style.setProperty('--img-width', `${informationBreadPoint.imgWidth}px`);
        parent.style.setProperty('--img-height', `${informationBreadPoint.imgHeight}px`);
        parent.style.setProperty('--scale-x', `${informationBreadPoint.scaleX}`);
        parent.style.setProperty('--scale-y', `${informationBreadPoint.scaleY}`);
    });
}
const sizeInformation = width => {
    const breakPointsInfo = [
        {width: 1920, imgWidth: 620, imgHeight: 465, scaleX: 1.5, scaleY: 1.5},
        {width: 1800, imgWidth: 568, imgHeight: 426, scaleX: 1.5, scaleY: 1.5},
        {width: 1600, imgWidth: 517, imgHeight: 388, scaleX: 1.5, scaleY: 1.5},
        {width: 1440, imgWidth: 465, imgHeight: 349, scaleX: 1.5, scaleY: 1.5},
        {width: 1280, imgWidth: 413, imgHeight: 310, scaleX: 1.3, scaleY: 1.3},
        {width: 1150, imgWidth: 356, imgHeight: 267, scaleX: 1.1, scaleY: 1.1},
        {width: 1024, imgWidth: 334, imgHeight: 251, scaleX: 1, scaleY: 1},
        {width: 960, imgWidth: 334, imgHeight: 251, scaleX: 1, scaleY: 1},
        {width: 768, imgWidth: 300, imgHeight: 225, scaleX: 1, scaleY: 1},
        {width: 640, imgWidth: 275, imgHeight: 197, scaleX: 1, scaleY: 1},
        {width: 576, imgWidth: 262, imgHeight: 183, scaleX: 1, scaleY: 1},
        {width: 480, imgWidth: 250, imgHeight: 169, scaleX: 1, scaleY: 1}
    ];
    const breakPoint = breakPointsInfo.find(bp => bp.width <= width);
    console.log(breakPoint);
    return breakPoint;
}

window.screenSize = screenSize;
window.sizeInformation = sizeInformation;
window.updateDimensions = updateDimensions;


