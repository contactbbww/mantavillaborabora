# CLAUDE.md — Octopus & Manta Villa

## Vue d'ensemble
Site vitrine one-page pour **Octopus & Manta Villa** — deux villas de charme avec piscine privée et accès direct au lagon à Bora Bora.

- **URL prod** : https://www.mantavillaborabora.com
- **Contact** : contact@mantavillaborabora.com · +689 89 22 13 76
- **Adresse** : Vai Api, Bora Bora, Polynésie française

---

## Stack technique

| Couche | Technologie |
|--------|-------------|
| HTML   | Vanilla HTML5 — fichier unique `index.html` |
| CSS    | Vanilla CSS — inline dans `index.html` |
| JS     | Vanilla JS — inline dans `index.html` |
| Fonts  | Google Fonts : Cormorant Garamond + DM Sans |
| Images | Fichiers JPEG dans `images/` (45 fichiers) |
| Déploiement | Git push → GitHub Actions → FTP Amen |

**Pas de framework, pas de bundler, pas de Node.js.**

---

## Structure du projet

```
mantavilla-site/
├── index.html          # Site complet (one-page)
└── images/             # 45 photos JPEG
    ├── hero.jpeg
    ├── oct-*.jpeg      # Photos Octopus Villa
    ├── man-*.jpeg      # Photos Manta Villa
    ├── act-*.jpeg      # Photos activités
    ├── hosts.jpeg      # Photo hôtes
    └── logo.jpeg / favicon.jpeg
```

---

## Système bilingue FR/EN

Via classes CSS `.fr-text` / `.en-text` sur les éléments.
- `.lang-en` ajoutée sur `<body>` pour passer en anglais
- `toggleLang()` gère le switch dans le JS

---

## Palette de couleurs

```css
--sand:    #f4efe6   /* fond général */
--ocean:   #1a4a5c   /* bleu profond */
--ocean-l: #2d7a8a   /* bleu clair */
--coral:   #c4624a   /* accent corail */
```

---

## Calendrier & iCal

- Calendrier JS maison, switch Octopus Villa / Manta Villa
- Sync iCal Airbnb via `corsproxy.io`
- URLs iCal Airbnb pré-configurées dans `autoSyncIcal()`
- Tarifs : Octopus 700€/nuit + 200€ ménage · Manta 170€/nuit + 60€ ménage

---

## Déploiement

- **"envoi sur amen"** = `git add` + `git commit` + `git push` → déploiement FTP automatique via GitHub Actions
- **Sans cette instruction** = modifications en local uniquement
- Ne jamais pusher sans instruction explicite "envoi sur amen"

## Secrets GitHub requis
- `FTP_HOST` — serveur FTP Amen
- `FTP_USERNAME` — identifiant FTP
- `FTP_PASSWORD` — mot de passe FTP
- `FTP_SERVER_DIR` — dossier de destination sur le serveur

---

*Créé : 2026-05-27*
