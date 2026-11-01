// Apply image replacements saved through the private Website Image Manager.
(async()=>{
 try{
  const response=await fetch('api/site-images.php',{headers:{Accept:'application/json'}});
  if(!response.ok)return;
  const data=await response.json();const images=data.images||{};
  const set=(key,element,mode='src')=>{const item=images[key];if(!item||!item.url||!element)return;if(mode==='background')element.style.setProperty('--hero',"url('"+item.url.replace(/'/g,"%27")+"')");else{element.src=item.url;if(item.alt)element.alt=item.alt;}};
  const slides=[...document.querySelectorAll('.hero-slide')];slides.forEach((el,i)=>set('home.hero.'+(i+1),el,'background'));
  set('home.about.large',document.querySelector('.intro-large'));set('home.about.small',document.querySelector('.intro-small'));
  const testimonial=document.querySelector('.testimonial-photo');if(images['home.testimonial']?.url&&testimonial)testimonial.style.backgroundImage="url('"+images['home.testimonial'].url.replace(/'/g,"%27")+"')";
  document.querySelectorAll('.journal-card img').forEach((el,i)=>set('home.journal.'+(i+1),el));
  document.querySelectorAll('.home-gallery-grid img').forEach((el,i)=>set('home.gallery.'+(i+1),el));
 }catch(error){console.info('Using default Wintrip website images.',error.message);}
})();