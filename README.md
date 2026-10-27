# Wintrip 1 — Travelix-inspired frontend

Wintrip 1 is a separate frontend design experiment for Wintrip Safaris, inspired by the structure and travel-discovery patterns of Colorlib's Travelix template. It is an independent static website; the existing `wintrip-safaris` repository is unchanged.

## Project contents

- `index.html` — responsive homepage layout
- `assets/css/style.css` — styling for desktop, tablet and mobile
- `assets/js/main.js` — hero carousel, destination cards and filters, search interactions, and demo enquiry email
- `vercel.json` — static deployment headers
- Wintrip Safaris logo is referenced from the original public repository

## Run locally

Open `index.html` in a browser or run a local static server from the repository root:

```bash
npx serve .
```

## Deploy to Vercel

Import this GitHub repository into Vercel:

- Framework Preset: **Other**
- Build Command: leave blank
- Output Directory: `.`
- Install Command: leave blank
- Environment variables: none required

## Interactions and limitations

The homepage is frontend-only. Destination filters, hero slides and trip-search interactions work in the browser. The enquiry form prepares a `mailto:` email and does not store enquiries or create bookings. No PHP, MySQL or backend API is required for this design prototype.

Destination and feature images use remote Unsplash URLs. Replace these with photos owned, licensed or otherwise authorized for Wintrip Safaris before production. The phone number is a placeholder; confirm company contact details before publishing.

## Reference

Visual inspiration: [Colorlib Travelix preview](https://preview.colorlib.com/?_gl=1*1or5451*_ga*NjMzOTA0NjY5LjE3OTMwOTY3NzE.*_ga_SEKJ4E9T4H*czE3OTMwOTY3NzEkbzEkZzEkdDE3OTMwOTY4NjgkajYwJGwwJGgwJGRUZVFGX2h4eDczM2Z2SDNhSC1vUjhuMkFvS3hOblVZZFh3#travelix).

This is a newly implemented design concept, not a copy of Colorlib's source code.
