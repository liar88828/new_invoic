<!--    end here-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous">
</script>


<script>
	const discountInput = document.getElementById('discount');

	discountInput.addEventListener('input', () => {
		if (discountInput.value > 100) {
			discountInput.value = 100; // Reset the value to the maximum allowed
		}
	});
</script>
</body>
</html>