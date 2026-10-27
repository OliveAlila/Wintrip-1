const destinations = [
  {name:'Maasai Mara',country:'KENYA',region:'Kenya',tag:'Wildlife & the Great Migration',days:'3–5 days',image:'photo-1516426122078-c23e76319801'},
  {name:'Amboseli',country:'KENYA',region:'Kenya',tag:'Elephants beneath Kilimanjaro',days:'2–4 days',image:'photo-1516026672322-bc52d61a55d5'},
  {name:'Diani Beach',country:'KENYA',region:'Coast',tag:'White sand & turquoise water',days:'3–6 days',image:'photo-1500375592092-40eb2168fd21'},
  {name:'Lamu',country:'KENYA',region:'Coast',tag:'Swahili heritage & island life',days:'2–4 days',image:'photo-1518509562904-e7ef99cdcc86'},
  {name:'Zanzibar',country:'TANZANIA',region:'Coast',tag:'Spice island & Indian Ocean shores',days:'4–7 days',image:'photo-1544551763-46a013bb70d5'},
  {name:'Cape Town',country:'SOUTH AFRICA',region:'Africa',tag:'Mountain, city & coast',days:'4–7 days',image:'photo-1580060839134-75a5edca2e99'},
  {name:'Dubai',country:'UAE',region:'Beyond',tag:'Desert adventures & skyline',days:'3–5 days',image:'photo-1512453979798-5ea266f8880c'},
  {name:'Naivasha',country:'KENYA',region:'Kenya',tag:'Lake escapes & Rift Valley views',days:'2–3 days',image:'photo-1470770841072-f978cf4d019e'}
];
const tours = [
  {name:'The Great Mara Escape',type:'SAFARI & WILDLIFE',duration:'4 days · 3 nights',description:'Look out for lions, elephants and sweeping savannah views on a classic Kenyan safari.',image:'photo-1516426122078-c23e76319801'},
  {name:'Diani Slow Days',type:'BEACH & RELAXATION',duration:'5 days · 4 nights',description:'Settle into coastal rhythms with beach time, ocean breezes and optional water adventures.',image:'photo-1500375592092-40eb2168fd21'},
  {name:'Amboseli & the Mountain',type:'WILDLIFE & SCENERY',duration:'3 days · 2 nights',description:'Experience wide-open landscapes and memorable elephant sightings beneath Kilimanjaro.',image:'photo-1516026672322-bc52d61a55d5'}
];
function imageUrl(id, width) {
  return 'https://images.unsplash.com/' + id + '?auto=format&fit=crop&w=' + (width || 850) + '&q=83';
}
const destinationGrid = document.querySelector('#destination-grid');
const tourGrid = document.querySelector('#tour-grid');

function renderDestinations(region) {
  const selectedRegion = region || 'All';
  const shown = destinations.filter(function (destination) {
    return selectedRegion === 'All' || destination.region === selectedRegion;
  });
  destinationGrid.innerHTML = shown.map(function (destination) {
    return '<article class="destination-card"><a href="#contact" class="destination-image" data-destination="' + destination.name + '"><img src="' + imageUrl(destination.image, 800) + '" alt="' + destination.name + '" loading="lazy"><span class="destination-country">' + destination.country + '</span></a><div class="destination-card-body"><h3>' + destination.name + '</h3><p>' + destination.tag + '</p><div class="destination-card-foot"><span>✦ ' + destination.days + '</span><a href="#contact" data-destination="' + destination.name + '">DISCOVER ↗</a></div></div></article>';
  }).join('');
}
function renderTours() {
  tourGrid.innerHTML = tours.map(function (tour) {
    return '<article class="tour-card"><div class="tour-image"><img src="' + imageUrl(tour.image, 900) + '" alt="' + tour.name + '" loading="lazy"><span class="tour-type">' + tour.type + '</span></div><div class="tour-body"><h3>' + tour.name + '</h3><p>' + tour.description + '</p><div class="tour-foot"><span>◷ ' + tour.duration + '</span><a href="#contact" data-destination="' + tour.name + '">ENQUIRE ↗</a></div></div></article>';
  }).join('');
}
renderDestinations();
renderTours();

document.querySelectorAll('.filter').forEach(function (button) {
  button.addEventListener('click', function () {
    document.querySelectorAll('.filter').forEach(function (item) { item.classList.toggle('active', item === button); });
    renderDestinations(button.dataset.region);
  });
});
const navToggle = document.querySelector('.nav-toggle');
const nav = document.querySelector('.nav');
navToggle.addEventListener('click', function () {
  const open = nav.classList.toggle('open');
  navToggle.setAttribute('aria-expanded', String(open));
  navToggle.textContent = open ? '×' : '☰';
});
nav.querySelectorAll('a').forEach(function (link) {
  link.addEventListener('click', function () {
    nav.classList.remove('open');
    navToggle.setAttribute('aria-expanded', 'false');
    navToggle.textContent = '☰';
  });
});

const slides = Array.from(document.querySelectorAll('.hero-slide'));
const dots = Array.from(document.querySelectorAll('.hero-dots button'));
let slideIndex = 0;
function goSlide(index) {
  slideIndex = (index + slides.length) % slides.length;
  slides.forEach(function (slide, i) { slide.classList.toggle('active', i === slideIndex); });
  dots.forEach(function (dot, i) { dot.classList.toggle('active', i === slideIndex); });
}
document.querySelector('.hero-arrow.prev').addEventListener('click', function () { goSlide(slideIndex - 1); });
document.querySelector('.hero-arrow.next').addEventListener('click', function () { goSlide(slideIndex + 1); });
dots.forEach(function (dot, i) { dot.addEventListener('click', function () { goSlide(i); }); });
let carouselTimer = setInterval(function () { goSlide(slideIndex + 1); }, 6500);
document.querySelector('.hero').addEventListener('mouseenter', function () { clearInterval(carouselTimer); });
document.querySelector('.hero').addEventListener('mouseleave', function () {
  clearInterval(carouselTimer);
  carouselTimer = setInterval(function () { goSlide(slideIndex + 1); }, 6500);
});

document.querySelectorAll('.search-tab').forEach(function (tab) {
  tab.addEventListener('click', function () {
    document.querySelectorAll('.search-tab').forEach(function (item) { item.classList.toggle('active', item === tab); });
    const select = document.querySelector('#search-destination');
    const kinds = {safaris:'Maasai Mara',beach:'Diani Beach',adventure:'Amboseli',family:'Naivasha'};
    if (kinds[tab.dataset.kind]) select.value = kinds[tab.dataset.kind];
  });
});
document.querySelector('#search-form').addEventListener('submit', function (event) {
  event.preventDefault();
  const destination = document.querySelector('#search-destination').value;
  const feedback = document.querySelector('#search-feedback');
  feedback.textContent = destination ? 'Great choice — ' + destination + '. Send us an enquiry below to plan this trip.' : 'Choose a destination or send us an enquiry and we will help you decide.';
  if (destination) {
    const field = document.querySelector('#contact-form [name="destination"]');
    field.value = destination;
    document.querySelector('#contact').scrollIntoView({behavior:'smooth'});
  }
});
document.addEventListener('click', function (event) {
  const link = event.target.closest('[data-destination]');
  if (!link) return;
  const field = document.querySelector('#contact-form [name="destination"]');
  const value = link.dataset.destination;
  if (field && Array.from(field.options).some(function (option) { return option.value === value; })) field.value = value;
  else if (field) field.value = 'Not sure yet';
});

document.querySelector('#contact-form').addEventListener('submit', function (event) {
  event.preventDefault();
  const data = new FormData(event.currentTarget);
  const subject = 'Wintrip travel enquiry — ' + (data.get('destination') || 'Trip planning');
  const body = [
    'Name: ' + data.get('name'),
    'Email: ' + data.get('email'),
    'Destination: ' + (data.get('destination') || 'Not decided'),
    'Travel date: ' + (data.get('date') || 'Flexible'),
    '',
    String(data.get('message') || '')
  ].join('\n');
  document.querySelector('#form-status').textContent = 'Opening your email app with the enquiry details. Nothing is saved by this demo.';
  window.location.href = 'mailto:wintripsafarishelp@gmail.com?subject=' + encodeURIComponent(subject) + '&body=' + encodeURIComponent(body);
});
const today = new Date();
const minDate = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2,'0') + '-' + String(today.getDate()).padStart(2,'0');
document.querySelectorAll('input[type="date"]').forEach(function (input) { input.min = minDate; });
