export function formatCurrencyInput(priceInput) {
    priceInput.addEventListener("input", function (e) {
        let value = e.target.value;

        value = value.replace(/\D/g, "");  // Remove caracteres que não são números
        if (value.length > 2) {
            value = value.slice(0, -2) + ',' + value.slice(-2);  // Adiciona vírgula para centavos
        }
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");  // Adiciona pontos para milhar

        e.target.value = value;
    });

    priceInput.addEventListener("blur", function () {
        let value = priceInput.value;

        if (value !== "" && !value.includes(",")) {
            value += ",00";
        } else if (value.endsWith(",")) {
            value += "00";
        } else if (value.split(",")[1].length === 1) {
            value += "0";
        }

        priceInput.value = value;
    });

    document.querySelector("form").addEventListener("submit", function (e) {
        let value = priceInput.value;

        value = value.replace(/\./g, "");  // Remove pontos de milhar
        value = value.replace(",", ".");  // Substitui a vírgula por ponto

        priceInput.value = value;  // Atualiza o campo com o valor formatado para enviar ao banco
    });
}
