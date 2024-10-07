export function handleAuthorInput() {
    const name_author = document.getElementById('name_author');
    const messageElement = document.getElementById('message'); // Certifique-se de que este ID está correto

    name_author.addEventListener('input', function (e) {
        let value = e.target.value;
        
        // Remove caracteres especiais e números (permite apenas letras e espaços)
        value = value.replace(/[^a-zA-ZÀ-ÿ\s]/g, "");  // Inclui suporte a acentos
    
        // Remove espaços extras
        value = value.replace(/\s{2,}/g, ' '); 

        // Atualiza o valor no input
        name_author.value = value;

        // Exibe mensagem de validação
        if (!value.trim()) {
            messageElement.innerHTML = 'Preencha o nome do autor';
        } else {
            messageElement.innerHTML = '';
        }
    });
}

export function handleISBNInput() {
    const isbnInput = document.getElementById('ISBN');
    const messageElement = document.getElementById('message'); // Certifique-se de que este ID está correto

    isbnInput.addEventListener('input', function (e) {
        let value = e.target.value;

        // Remove caracteres que não sejam dígitos ou hifens (opcional)
        value = value.replace(/[^0-9\-]/g, '');

        // Remove espaços extras
        value = value.replace(/\s{2,}/g, ' ');

        // Atualiza o valor no input
        isbnInput.value = value;

        // Exibe mensagem de validação
        if (!value.trim()) {
            messageElement.innerHTML = 'Preencha o ISBN do Livro';
        } else if (!/^\d{10}(\-\d{3})?$|^\d{13}$/.test(value)) {
            // Validação para ISBN-10 ou ISBN-13 (com ou sem hifens)
            messageElement.innerHTML = 'ISBN inválido. Deve conter 10 ou 13 dígitos';
        } else {
            messageElement.innerHTML = '';
        }
    });
}

export function handleTitleInput() {
    const title = document.getElementById('title');
    const messageElement = document.getElementById('message'); // Certifique-se de que este ID está correto

    title.addEventListener('input', function (e) {
        let value = e.target.value;
        
        // Remove caracteres especiais e números (permite apenas letras e espaços)
        value = value.replace(/[^a-zA-ZÀ-ÿ\s]/g, "");  // Inclui suporte a acentos
    
        // Remove espaços extras
        value = value.replace(/\s{2,}/g, ' '); 

        // Atualiza o valor no input
        title.value = value;

        // Exibe mensagem de validação
        if (!value.trim()) {
            messageElement.innerHTML = 'Preencha o título do Livro';
        } else {
            messageElement.innerHTML = '';
        }
    });
}
export function handle_Id_Author_Input() {
    const id_author = document.getElementById('id_author');
    const messageElement = document.getElementById('message'); // Certifique-se de que este ID está correto

    // Escuta o evento de mudança de valor no select
    id_author.addEventListener('change', function (e) {
        let value = e.target.value;

        // Exibe mensagem de validação
        if (!value.trim()) {
            messageElement.innerHTML = 'Selecione o autor do Livro';
        } else {
            messageElement.innerHTML = '';
        }
    });
}
export function handle_CPF_Input() {
    const CPF_Input = document.getElementById('CPF'); // Captura o campo de CPF
    const messageElement = document.getElementById('message'); // Certifique-se de que este ID está correto

    CPF_Input.addEventListener('input', function (e) {
        let value = e.target.value;

        // Remove espaços extras
        value = value.replace(/\s{2,}/g, ' ');

        // Atualiza o valor no input
        CPF_Input.value = value;

        // Exibe mensagem de validação
        if (!value.trim()) {
            messageElement.innerHTML = 'Preencha o CPF';
        } else if (!/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/.test(value)) { // Valida o formato de CPF (XXX.XXX.XXX-XX)
            messageElement.innerHTML = 'CPF é inválido';
        } else {
            messageElement.innerHTML = ''; // Limpa a mensagem de erro se o CPF estiver válido
        }
    });
}

export function handle_name_client_Input() {
    const name_client_Input = document.getElementById('name_client'); // Captura o campo de nome do cliente
    const messageElement = document.getElementById('message'); // Certifique-se de que este ID está correto

    name_client_Input.addEventListener('input', function (e) {
        let value = e.target.value;

        // Remove caracteres especiais e números
        value = value.replace(/[^a-zA-Z\s]/g, '');

        // Remove espaços extras
        value = value.replace(/\s{2,}/g, ' ');

        // Atualiza o valor no input
        name_client_Input.value = value;

        // Exibe mensagem de validação
        if (!value.trim()) {
            messageElement.innerHTML = 'Preencha o nome do cliente';
        } else {
            messageElement.innerHTML = ''; // Limpa a mensagem de erro se o nome estiver válido
        }
    });
}

export function handle_email_client_Input() {
    const email_client_Input = document.getElementById('email_client'); // Captura o campo de e-mail do cliente
    const messageElement = document.getElementById('message'); // Captura o elemento de mensagem

    email_client_Input.addEventListener('input', function (e) {
        let value = e.target.value;

        // Expressão regular para validar o formato do e-mail
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        // Atualiza o valor no input
        email_client_Input.value = value;

        // Exibe mensagem de validação
        if (!value.trim()) {
            messageElement.innerHTML = 'Preencha o campo e-mail';
        } else if (!emailPattern.test(value)) {
            messageElement.innerHTML = 'E-mail inválido';
        } else {
            messageElement.innerHTML = ''; // Limpa a mensagem de erro se o e-mail estiver válido
        }
    });
}

export function handleQuantInput() {
    const quantity_item_Input = document.getElementById('quantity_item');
    const messageElement = document.getElementById('message'); // Certifique-se de que este ID está correto

    quantity_item_Input.addEventListener('input', function (e) {
        let value = e.target.value;

        // Remove caracteres que não sejam dígitos
        value = value.replace(/[^0-9]/g, '');

        // Atualiza o valor no input
        quantity_item_Input.value = value;

        // Exibe mensagem de validação
        if (!value.trim()) {
            messageElement.innerHTML = 'Preencha o campo quantidade';
        } else {
            messageElement.innerHTML = '';
        }
    });
}

export function handle_Quant_stock_Input() {
    const quantity_stock = document.getElementById('quantity_stock');
    const messageElement = document.getElementById('message'); // Certifique-se de que este ID está correto

    quantity_stock.addEventListener('input', function (e) {
        let value = e.target.value;

        // Remove caracteres que não sejam dígitos
        value = value.replace(/[^0-9]/g, '');

        // Atualiza o valor no input
        quantity_stock.value = value;

        // Exibe mensagem de validação
        if (!value.trim()) {
            messageElement.innerHTML = 'Preencha o campo quantidade';
        } else {
            messageElement.innerHTML = '';
        }
    });
}
