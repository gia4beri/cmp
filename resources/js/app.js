import "./bootstrap";

window.invoiceItemFieldRemove = function invoiceItemRemove(button){
    let invoiceItemsCount = document.getElementsByClassName('invoice-item');

    if (invoiceItemsCount.length >= 2){
        let closestDiv = button.closest('.invoice-item');
        closestDiv.remove();
    }
}

window.addInvoiceItemField = function addInvoiceItem(button){
    let parentDiv = document.getElementById('invoice-items');
    let cloneDiv = document.getElementById('invoice-item');
    let clonedDiv = cloneDiv.cloneNode(true);
    let inputs = clonedDiv.querySelectorAll('input');
    inputs.forEach(input => {
        input.value = '';
    });
    parentDiv.appendChild(clonedDiv);
}

var executed = false;
window.invoiceAddService = function invoiceAddService(button){

    let invoiceService = document.getElementById('invoice-services');
    let value = invoiceService.value;
    let text = invoiceService.options[invoiceService.selectedIndex].text;

    let parentDiv = document.getElementById('invoice-items');
    let cloneDiv = document.getElementById('invoice-item');
    let clonedDiv = cloneDiv.cloneNode(true);

    if(!executed){
        cloneDiv.remove();
        executed = true;
    }

    let inputs = clonedDiv.querySelectorAll('input');
    inputs.forEach(input => {
        input.value = '';
    });

    let serviceNameInput = clonedDiv.querySelector('.service-name');
    serviceNameInput.value = text;

    let servicePriceInput = clonedDiv.querySelector('.service-price');
    servicePriceInput.value = value;

    let serviceQuantityInput = clonedDiv.querySelector('.service-quantity');
    serviceQuantityInput.value = 1;

    parentDiv.appendChild(clonedDiv);
}
window.invoiceAddConsultation = function invoiceAddConsultation(button){

    let invoiceConsultation = document.getElementById('invoice-consultations');
    let value = invoiceConsultation.value;
    let doctor = invoiceConsultation.options[invoiceConsultation.selectedIndex].getAttribute('data-doctor');
    let proficiency = invoiceConsultation.options[invoiceConsultation.selectedIndex].getAttribute('data-proficiency');
    let text = invoiceConsultation.options[invoiceConsultation.selectedIndex].text;

    let parentDiv = document.getElementById('invoice-items');
    let cloneDiv = document.getElementById('invoice-item');
    let clonedDiv = cloneDiv.cloneNode(true);

    if(!executed){
        cloneDiv.remove();
        executed = true;
    }

    let inputs = clonedDiv.querySelectorAll('input');
    inputs.forEach(input => {
        input.value = '';
    });

    let serviceDoctorInput = clonedDiv.querySelector('.service-doctor');
    serviceDoctorInput.value = doctor;

    let serviceNameInput = clonedDiv.querySelector('.service-name');
    serviceNameInput.value = proficiency + ' - კონსულტაცია';

    let servicePriceInput = clonedDiv.querySelector('.service-price');
    servicePriceInput.value = value;

    let serviceQuantityInput = clonedDiv.querySelector('.service-quantity');
    serviceQuantityInput.value = 1;

    parentDiv.appendChild(clonedDiv);
}

window.modal_form_show = function modal_form_show(){
    let modal_form = document.getElementById('modal-form');
    modal_form.classList.remove('hidden');
}

window.modal_form_hide = function modal_form_hide(redirect_path){
    let modal_form = document.getElementById('modal-form');
    modal_form.classList.add('hidden');
    window.location.href = redirect_path;
}

let role_select = document.getElementById('select-role');
let input_proficiency = document.getElementById('input-proficiency');
let input_consultation_price = document.getElementById('input-consultation-price');

if(role_select){
    role_select.addEventListener('change', function(){
        let value = role_select.value;
        if(value === 'doctor'){
            input_proficiency.disabled = false;
            input_consultation_price.disabled = false;
        } else {
            input_proficiency.disabled = true;
            input_consultation_price.disabled = true;
        }
    });
}

window.addEventListener('load',function(){
    let role_select = document.getElementById('select-role');
    let input_proficiency = document.getElementById('input-proficiency');
    let input_consultation_price = document.getElementById('input-consultation-price');

    if(role_select){
        let value = role_select.value;
        if(value === 'doctor'){
            input_proficiency.disabled = false;
            input_consultation_price.disabled = false;
        } else {
            input_proficiency.disabled = true;
            input_consultation_price.disabled = true;
        }
    }
});

let payment_method = document.getElementById('payment-method');
let insurance_input = document.getElementById('insurance');
let insurance_code_input = document.getElementById('insurance-code');

if (payment_method){
    payment_method.addEventListener('change', function (){
        let value = payment_method.value;

        if(value === 'სადაზღვეო კომპანია'){
            insurance_code_input.disabled = false
            insurance_input.disabled = false;
        } else {
            insurance_code_input.disabled = true;
            insurance_input.disabled = true;
        }
    });
}

window.onload = function (){
    let payment_method = document.getElementById('payment-method');
    let insurance_input = document.getElementById('insurance');
    let insurance_code_input = document.getElementById('insurance+_code');

    if (payment_method){
        let value = payment_method.value;

        if(value === 'სადაზღვეო კომპანია'){
            insurance_code_input.disabled = false
            insurance_input.disabled = false;
        } else {
            insurance_code_input.disabled = true;
            insurance_input.disabled = true;
        }
    }
}


let birthdateInput = document.getElementById("birth-date");
let parent_first_name = document.getElementById("parent_first_name");
let parent_last_name = document.getElementById("parent_last_name");
let parent_personal_number = document.getElementById("parent_personal_number");

if (birthdateInput) {
    birthdateInput.addEventListener('change', function (){
        let value = birthdateInput.value;
        let birthdate = new Date(value);
        let today = new Date();

        let age = today.getFullYear() - birthdate.getFullYear();
        let monthDifference = today.getMonth() - birthdate.getMonth();

        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthdate.getDate())) {
            age--;
        }

        if (age < 17) {
            parent_first_name.disabled = false;
            parent_last_name.disabled = false;
            parent_personal_number.disabled = false;
        } else {
            parent_first_name.disabled = true;
            parent_last_name.disabled = true;
            parent_personal_number.disabled = true;
        }
    });
}

window.onload = function (){
    let birthdateInput = document.getElementById("birth-date");
    let parent_first_name = document.getElementById("parent_first_name");
    let parent_last_name = document.getElementById("parent_last_name");
    let parent_personal_number = document.getElementById("parent_personal_number");

    if (birthdateInput) {
        let value = birthdateInput.value;
        let birthdate = new Date(value);
        let today = new Date();

        let age = today.getFullYear() - birthdate.getFullYear();
        let monthDifference = today.getMonth() - birthdate.getMonth();

        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthdate.getDate())) {
            age--;
        }

        if (age < 17) {
            parent_first_name.disabled = false;
            parent_last_name.disabled = false;
            parent_personal_number.disabled = false;
        } else {
            parent_first_name.disabled = true;
            parent_last_name.disabled = true;
            parent_personal_number.disabled = true;
        }
    }
}
