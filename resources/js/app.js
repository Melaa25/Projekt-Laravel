import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", function () {
    // Pobierz przyciski z DOM
    const increaseFontButton = document.getElementById("increaseFont");
    const decreaseFontButton = document.getElementById("decreaseFont");

    // Domyślny rozmiar czcionki (zapisany w sessionStorage lub 100%)
    let fontSize = sessionStorage.getItem("fontSize") 
        ? parseInt(sessionStorage.getItem("fontSize"), 10) 
        : 100;

    // Funkcja aktualizująca rozmiar czcionki
    function updateFontSize() {
        document.body.style.fontSize = fontSize + "%";

        // Zapisz bieżący stan w sessionStorage
        sessionStorage.setItem("fontSize", fontSize);
    }

    // Funkcja zwiększania czcionki
    if (increaseFontButton) {
        increaseFontButton.addEventListener("click", function () {
            if (fontSize < 300) { // Maksymalny limit
                fontSize += 10;
                updateFontSize();
            }
        });
    }

    // Funkcja zmniejszania czcionki
    if (decreaseFontButton) {
        decreaseFontButton.addEventListener("click", function () {
            if (fontSize > 50) { // Minimalny limit
                fontSize -= 10;
                updateFontSize();
            }
        });
    }

    // Zastosuj zapisany rozmiar czcionki przy pierwszym załadowaniu
    updateFontSize();
});
