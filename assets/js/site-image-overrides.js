// Load saved homepage images from the image manager and replace the matching defaults.
(async()=>{
 let images={};
 const imageUrl=value=>{
  const raw=String(value||'').trim();
  if(!raw)return '';
  try{return new URL(raw,document.baseURI).href;}catch(_){return raw;}
 };
 const applyImage=(key,element,mode)=>{
  const item=images[key];if(!item||!item.url||!element)return;
  const url=imageUrl(item.url);if(!url)return;
  if(mode==='background')element.style.setProperty('--hero','url("'+url.replace(/"/g,'%22')+'")');
  else{element.src=url;if(item.alt)element.alt=item.alt;}
 };
 try{
  const response=await fetch('api/site-images.php?refresh='+Date.now(),{headers:{Accept:'application/json'},cache:'no-store'});
  if(!response.ok)throw new Error('Image settings could not be loaded ('+response.status+').');
  const data=await response.json();images=data.images||{};
  document.querySelectorAll('.hero-slide').forEach((el,i)=>applyImage('home.hero.'+(i+1),el,'background'));
  applyImage('home.about.large',document.querySelector('.intro-large'));
  applyImage('home.about.small',document.querySelector('.intro-small'));
  const testimonial=document.querySelector('.testimonial-photo');
  if(images['home.testimonial']&&images['home.testimonial'].url&&testimonial){
   const url=imageUrl(images['home.testimonial'].url);
   testimonial.style.backgroundImage='url("'+url.replace(/"/g,'%22')+'")';
  }
  document.querySelectorAll('.journal-card img').forEach((el,i)=>applyImage('home.journal.'+(i+1),el,'src'));
  document.querySelectorAll('.home-gallery-grid img').forEach((el,i)=>applyImage('home.gallery.'+(i+1),el,'src'));
 }catch(error){console.warn('Wintrip homepage image overrides:',error.message);}
})();
