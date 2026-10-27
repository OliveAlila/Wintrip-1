# Wintrip 1 — Travelix-inspired frontend

A frontend-only Wintrip Safaris design experiment inspired by the layout and travel-planning patterns of Colorlib's Travelix preview. This is an independent static site and does not change the original `wintrip-safaris` repository.

## Contents
- `index.html` — homepage layout and content
- `assets/css/styles.css` — responsive styling
- `assets/js/main.js` — hero, destination filters, trip search and mock enquiry interactions
- `assets/images/wintrip-logo.png` — Wintrip Safaris branding
- `vercel.json` — static deployment configuration

## Run locally
Open `index.html` in a browser, or run a static server from the repository root, for example `npx serve .`.

## Deploy to Vercel
Import this repository into Vercel. Framework Preset: Other. Build Command: leave blank. Output Directory: `.`. No environment variables are needed.

## Notes
This is a design prototype only. Search and enquiry interactions are frontend demonstrations; they do not submit to a database or create bookings. Destination imagery uses remote Unsplash image URLs and should be replaced with licensed/authorized photos before production.
