{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Payment Plan</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <h1>Choose Your Payment Plan</h1>
    <form id="payment-form">
        <label>
            <input type="radio" name="plan" value="price_monthly" checked> Monthly Plan
        </label>
        <label>
            <input type="radio" name="plan" value="price_yearly"> Yearly Plan
        </label>

        <!-- Stripe Elements Placeholder -->
        <div id="card-element"></div>

        <button id="submit-button">Subscribe</button>
    </form>

    <script>
        const stripe = Stripe('{{ config('services.stripe.key') }}');
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        const form = document.getElementById('payment-form');
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const { error, paymentMethod } = await stripe.createPaymentMethod({
                type: 'card',
                card: cardElement,
            });

            if (error) {
                alert(error.message);
            } else {
                const plan = document.querySelector('input[name="plan"]:checked').value;
                fetch('/subscribe', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ paymentMethod: paymentMethod.id, plan }),
                }).then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          window.location.href = '/success';
                      } else {
                          alert('Subscription failed. Please try again.');
                      }
                  });
            }
        });
    </script>
</body>
</html> --}}

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Payment Plan</title>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-lg w-full bg-white shadow-lg rounded-lg p-8">
        <h1 class="text-2xl font-bold text-center mb-6">Choose Your Payment Plan</h1>
        <form id="payment-form" class="space-y-6">
            <!-- Radio Buttons -->
            <fieldset class="space-y-4">
                <label class="flex items-center space-x-2">
                    <input type="radio" name="plan" value="price_monthly" checked class="form-radio text-blue-600 focus:ring focus:ring-blue-200">
                    <span>Monthly Plan</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="radio" name="plan" value="price_yearly" class="form-radio text-blue-600 focus:ring focus:ring-blue-200">
                    <span>Yearly Plan</span>
                </label>
            </fieldset>

            <!-- Stripe Card Element -->
            <div id="card-element" class="border border-gray-300 rounded p-4"></div>

            <!-- Submit Button -->
            <button id="submit-button" type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                Subscribe
            </button>
        </form>
    </div>

    <script>
        const stripe = Stripe('{{ config('services.stripe.key') }}');
        const elements = stripe.elements();
        const cardElement = elements.create('card', { style: { base: { fontSize: '16px' } } });
        cardElement.mount('#card-element');

        const form = document.getElementById('payment-form');
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const { error, paymentMethod } = await stripe.createPaymentMethod({
                type: 'card',
                card: cardElement,
            });

            if (error) {
                alert(error.message);
            } else {
                const plan = document.querySelector('input[name="plan"]:checked').value;
                fetch('/subscribe', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ paymentMethod: paymentMethod.id, plan }),
                }).then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          window.location.href = '/success';
                      } else {
                          alert('Subscription failed. Please try again.');
                      }
                  });
            }
        });
    </script>
</body>
