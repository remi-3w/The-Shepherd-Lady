const stripe = Stripe(stripePublicKey);
      
var elements = stripe.elements();
          
      var style = {
      base: {
      color: 'purple',
      fontWeight: 1700 ,
      fontFamily: 'Source Code Pro, Consolas, Menlo, monospace',
      fontSize: '16px',
      backgroundColor: 'pink',
      fontSmoothing: 'antialiased',

      '::placeholder': {
        color: 'grey',
      },
      ':-webkit-autofill': {
        color: '#e39f48',
      },
    },
    invalid: {
      color: '#E25950',

      '::placeholder': {
        color: '#FFCCA5',
      },
    },
  };
    var card = elements.create("card",{ style: style });
      
      card.mount("#card-element");
      card.on("change", function (event) {
      
        document.querySelector("button").disabled = event.empty;
        document.querySelector("#card-error").textContent = event.error ? event.error.message : "";
      });
      
      const form = document.getElementById("payment-form");
      form.addEventListener("submit", function(event) {
        event.preventDefault();      
        
        stripe
          .confirmCardPayment(clientSecret, {
                  payment_method: {
                      card: card
                  }
              })
              .then(function(result) {
              if (result.error) {
                
                  console.log(result.error.message);
              } else {
               
               window.location.href = redirectAfterSuccesUrl;
               
            
                }
              });
      });      