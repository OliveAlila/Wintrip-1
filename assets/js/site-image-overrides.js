// Load saved homepage images from the image manager and replace the matching defaults.
(async()=>{
 const imageUrl=value=>{
  const raw=String(value||'').trim();
  if(!raw)return '';
  try{return new URL(raw,document.baseURI).href;}catch(_){return raw;}
 };
 const applyImage=(key,element,mode='src')=>{
  const item=images[key]; if(!item||!item.url||!element)return;
  const url=imageUrl(item.url); if(!url)return;
  if(mode==='background') element.style.setProperty('--hero',\x60url("\x24{url.replace(/"/g,'%22')}")\x60);
  else {element.src=url;if(item.alt)element.alt=item.alt;}
 };
 let images={};
 try{
  const response=await fetch('api/site-images.php?refresh='+Date.now(),{headers:{Accept:'application/json'},cache:'no-store'});
  if(!response.ok)throw new Error('Image settings could not be loaded ('+response.status+').');
  const data=await response.json(); images=data.images||{};
  document.querySelectorAll('.hero-slide').forEach((el,i)=>applyImage('home.hero.'+(i+1),el,'background'));
  applyImage('home.about.large',document.querySelector('.intro-large'));
  applyImage('home.about.small',document.querySelector('.intro-small'));
  const testimonial=document.querySelector('.testimonial-photo');
  if(images['home.testimonial']?.url&&testimonial){const url=imageUrl(images['home.testimonial'].url);testimonial.style.backgroundImage=\x60url("\x24{url.replace(/"/g,'%22')}")\x60;}
  document.querySelectorAll('.journal-card img').forEach((el,i)=>applyImage('home.journal.'+(i+1),el));
  document.querySelectorAll('.home-gallery-grid img').forEach((el,i)=>applyImage('home.gallery.'+(i+1),el));
 }catch(error){console.warn('Wintrip homepage image overrides:',error.message);}
})();
