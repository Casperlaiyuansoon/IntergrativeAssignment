var sitePlusMinus = function(){
    var quantitySection = document.getElementsByClassName('quantity');

    function quantityBinding(quantitySection){
        const increaseButton = quantitySection.getElementsByClassName('increase')[0];
        const decreaseButton = quantitySection.getElementsByClassName('decrease')[0];
        const quantityAmount = quantitySection.getElementsByClassName('quantity-amount')[0];

        increaseButton.addEventListener('click', function(){
            increaseValue(quantityAmount);
        })
    }

    function initiate(){
        for (var i = 0; i < quantitySection.length; i++){
            quantityBinding(quantitySection[i]);
        }
    }

    function increaseValue(quantityAmount){
        const increament = 1;
        let total = 0;
        let value = parseInt(quantityAmount.value);
        value = isNaN(value) ? 0 : value;
        value += increament;
        quantityAmount.value = value;


    }
    initiate();
};
sitePlusMinus();