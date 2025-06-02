document.getElementById('subscribeForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    const email = document.getElementById('emailInput').value;
    const messageEl = document.getElementById('responseMessage');

    try {
        const response = await fetch('/subscribe', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ email })
        });

        const result = await response.json();

        if (response.ok) {
            messageEl.textContent = result.message;
            messageEl.classList.remove('text-red-400');
            messageEl.classList.add('text-green-400');
        } else {
            messageEl.textContent = result.message || 'There was an error.';
            messageEl.classList.add('text-red-400');
        }
    } catch (error) {
        messageEl.textContent = 'Submission failed. Try again.';
        messageEl.classList.add('text-red-400');
    }
});
