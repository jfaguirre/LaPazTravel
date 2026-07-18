import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


const regions = document.querySelectorAll('.region');
const tooltip = document.getElementById('tooltip');
const tooltipName = document.getElementById('tooltipName');
const tooltipInfo = document.getElementById('tooltipInfo');
const infoPanel = document.getElementById('infoPanel');
const legendItems = document.querySelectorAll('.legend-item');

regions.forEach(region => {
    region.addEventListener('mouseenter', (e) => {
        const name = region.getAttribute('data-name');
        const info = region.getAttribute('data-info');
        tooltipName.textContent = name;
        tooltipInfo.textContent = info;
        tooltip.classList.add('visible');
        
        // Posicionar tooltip sobre la región
        const rect = region.getBoundingClientRect();
        tooltip.style.left = (rect.left + rect.width / 2) + 'px';
        tooltip.style.top = rect.top + 'px';

        infoPanel.classList.add('active');
        infoPanel.innerHTML = `
            <div>
                <h3 style="color: ${getColor(region.classList)}">${name}</h3>
                <p>${info}</p>
            </div>
        `;
    });

    region.addEventListener('mouseleave', () => {
        tooltip.classList.remove('visible');
        infoPanel.classList.remove('active');
        setTimeout(() => {
            if (!infoPanel.classList.contains('active')) {
                infoPanel.innerHTML = `
                    <div>
                        <h3>Explora el Mapa</h3>
                        <p>Pasa el cursor sobre una región para ver información</p>
                    </div>
                `;
            }
        }, 300);
    });

    region.addEventListener('click', () => {
        const name = region.getAttribute('data-name');
        alert(`Has seleccionado: ${name}`);
    });
});

// Leyenda interactiva
legendItems.forEach(item => {
    item.addEventListener('mouseenter', () => {
        const regionName = item.getAttribute('data-region');
        const region = document.querySelector(`.region-${regionName}`);
        if (region) region.dispatchEvent(new Event('mouseenter'));
    });

    item.addEventListener('mouseleave', () => {
        const regionName = item.getAttribute('data-region');
        const region = document.querySelector(`.region-${regionName}`);
        if (region) region.dispatchEvent(new Event('mouseleave'));
    });
});

function getColor(classList) {
    if (classList.contains('region-oeste')) return '#e74c3c';
    if (classList.contains('region-centro')) return '#3498db';
    if (classList.contains('region-este')) return '#2ecc71';
    return '#ffffff';
}