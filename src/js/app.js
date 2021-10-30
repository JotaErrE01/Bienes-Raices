'use-strict';

document.addEventListener('DOMContentLoaded', function(){
    eventListeners();
    darkMode();
});

function eventListeners(){
    const $mobileMenu = document.querySelector('.mobile-menu');

    $mobileMenu.addEventListener('click', navegacinResponsive);
}


function navegacinResponsive(){
    const $navegacion = document.querySelector('.navegacion'); 
    $navegacion.classList.toggle('mostrar');
}

function darkMode(){

    const prefireDarkMode = window.matchMedia('(prefers-color-scheme: dark)');
    
    if(prefireDarkMode.matches){
        document.body.classList.add('dark-mode');
    }else{
        document.body.classList.remove('dark-mode');
    }

    prefireDarkMode.addEventListener('change', () => {
        if(prefireDarkMode.matches){
            document.body.classList.add('dark-mode');
        }else{
            document.body.classList.remove('dark-mode');
        }
    });

    const $darkMode = document.querySelector('.dark-mode-boton');
    $darkMode.addEventListener('click', function(){
        document.body.classList.toggle('dark-mode');
    });
}