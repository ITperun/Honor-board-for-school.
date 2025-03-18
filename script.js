let slides = document.querySelectorAll('.slide');
let index = 0;
let slideCount = slides.length; // Pamatujeme si počet snímků
let rotationCounter = 0; // Počítadlo celých cyklů karuselu

// Funkce pro přepínání snímků
function nextSlide() {
    if (slides.length > 0) {
        slides[index].style.display = 'none';
        index = (index + 1) % slides.length;
        slides[index].style.display = 'block';

        // Zkontrolujeme, zda cyklus karuselu skončil
        if (index === 0) {
            rotationCounter++;
            fetchNewPosts(); // Načítáme nové příspěvky až po dokončení cyklu
        }
    }
}

// Přepínáme snímky každých 10 sekund
setInterval(nextSlide, 10000);

// Funkce pro načítání nových příspěvků bez znovunačtení stránky
function fetchNewPosts() {
    fetch('data.json')
        .then(response => response.json())
        .then(data => {
            let carousel = document.querySelector('.carousel');
            carousel.innerHTML = ''; // Vyčistíme karusel

            data.forEach(item => {
                let slide = document.createElement('div');
                slide.classList.add('slide');

                slide.innerHTML = `
                    <div class="slide-content">
                        <img src="uploads/${item.image}" alt="Obrázek">
                        <div class="text">
                            <h2>${item.record}</h2>
                            <p><strong>Datum:</strong> ${item.date}</p>
                            <p><strong>Jméno:</strong> ${item.name}</p>
                            <p><strong>Třída:</strong> ${item.class}</p>
                        </div>
                    </div>
                `;

                carousel.appendChild(slide);
            });

            // Aktualizujeme seznam snímků
            slides = document.querySelectorAll('.slide');
            slideCount = slides.length; // Aktualizujeme celkový počet snímků

            if (slides.length > 0) {
                slides.forEach(slide => (slide.style.display = 'none'));
                slides[0].style.display = 'block';
                index = 0; // Začínáme nový cyklus zobrazení
            }
        })
        .catch(error => console.error('Neočekávaná chyba:', error));
}
