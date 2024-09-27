//Tippy
tippy('#tooltip-img', {
    content: 'To ensure we provide you with the most accurate service and pricing, could you please share a photo of your waste? This helps us verify there is no contamination, ensuring a smooth and efficient process for you',
});


let tooltips = document.querySelectorAll('.tippy_tooltip');
tooltips.forEach(tooltip => {
    var text = tooltip.getAttribute('tool-tip-text');
    if(text !== null || text !== ''){
        tippy(tooltip, {
            content: text ,
        });
    }
});

