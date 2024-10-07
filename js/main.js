import { maskCPF } from './maskCPF.js';
import { maskCEP } from './maskCEP.js';
import { validateForm } from './validateForm.js';
import { formatCurrencyInput } from './format_currency.js';
import { handleAuthorInput, handleISBNInput, handleTitleInput, handle_Id_Author_Input, handle_CPF_Input, handle_name_client_Input, handle_email_client_Input, handleQuantInput, handle_Quant_stock_Input} from './messages.js'; 

document.addEventListener('DOMContentLoaded', () => {
    // Aplica máscara de CPF no campo de input de CPF
    const cpfInput = document.getElementById('CPF');
    if (cpfInput) {
        maskCPF(cpfInput);
        handle_CPF_Input(cpfInput);
    }

    // Aplica máscara de CEP no campo de input de CEP
    const cepInput = document.getElementById('CEP');
    if (cepInput) {
        maskCEP(cepInput);
    }

    // Valida o formulário
    const form = document.querySelector('form');
    if (form) {
        validateForm(form);
    }

    const priceInput = document.getElementById("price");

    if (priceInput) {
        formatCurrencyInput(priceInput);
    }
    const name_author = document.getElementById('name_author');

    if(name_author) {
        handleAuthorInput();
    }

    const isbn_input = document.getElementById('ISBN');
    if(isbn_input) {
        handleISBNInput();
    }

    const title_input = document.getElementById('title');
    if(title_input) {
        handleTitleInput();
    }

    const id_author = document.getElementById('id_author');
    if(id_author) {
        handle_Id_Author_Input();
    }

    const name_client = document.getElementById('name_client');
    if(name_client) {
        handle_name_client_Input();
    }

    const email_client = document.getElementById('email_client');
    if(email_client) {
        handle_email_client_Input()    
    }

    const quantity_item = document.getElementById('quantity_item');
    if(quantity_item) {
        handleQuantInput()    
    }

    const quantity_stock = document.getElementById('quantity_stock');
    if(quantity_item) {
        handle_Quant_stock_Input()    
    }
})

