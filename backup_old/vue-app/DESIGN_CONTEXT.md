# DESIGN_CONTEXT — TPQ Darul Ikhlas

> Extracted from Stitch Project `3974585341321679131` — "Darul Ikhlas Management System"
> Last synced: 2026-05-05

---

## 1. Brand & Philosophy

**Name:** Islamic Education Design System  
**Aesthetic:** Minimalist & Modern — high whitespace, breathable layout, editorial feel  
**Mood:** Serene, Professional, Trustworthy  
**Cultural:** Subtle Islamic geometric patterns (2-5% opacity watermarks)

---

## 2. Color Palette

### Primary
| Token | Hex | Usage |
|---|---|---|
| `primary` | `#004d34` | Primary text accents |
| `primary-container` | `#006747` | **Main brand color** — buttons, headers, nav |
| `on-primary` | `#ffffff` | Text on primary surfaces |
| `on-primary-container` | `#8fe2ba` | Text on primary containers |
| `inverse-primary` | `#84d7af` | Dark mode primary |

### Secondary (Mint)
| Token | Hex | Usage |
|---|---|---|
| `secondary` | `#4f635b` | Secondary text |
| `secondary-container` | `#d1e7dd` | **Mint accent** — tags, badges, secondary buttons |
| `on-secondary` | `#ffffff` | Text on secondary |
| `on-secondary-container` | `#556961` | Text on secondary containers |

### Tertiary (Dark Slate)
| Token | Hex | Usage |
|---|---|---|
| `tertiary` | `#3d4446` | Tertiary elements |
| `tertiary-container` | `#545b5d` | Dark containers |

### Surface & Background
| Token | Hex | Usage |
|---|---|---|
| `background` | `#f7faf5` | **Page background** |
| `surface` | `#f7faf5` | Component surface |
| `surface-container-lowest` | `#ffffff` | **Card backgrounds** |
| `surface-container-low` | `#f1f5f0` | Subtle containers |
| `surface-container` | `#ebefea` | Default containers |
| `surface-container-high` | `#e5e9e4` | Elevated containers |
| `surface-container-highest` | `#e0e3df` | Most elevated |
| `surface-dim` | `#d7dbd6` | Dimmed surface |
| `on-surface` | `#181d1a` | **Primary text color** |
| `on-surface-variant` | `#3f4943` | Secondary text |

### Outline
| Token | Hex | Usage |
|---|---|---|
| `outline` | `#6f7a72` | Borders, dividers |
| `outline-variant` | `#bec9c1` | Subtle borders |

### Semantic
| Token | Hex | Usage |
|---|---|---|
| `error` | `#ba1a1a` | Error states |
| `error-container` | `#ffdad6` | Error backgrounds |
| `on-error` | `#ffffff` | Text on error |

---

## 3. Typography

**Font Family:** Plus Jakarta Sans (Google Fonts)  
**Weights:** 400 (Regular), 500 (Medium), 600 (SemiBold), 700 (Bold)

| Scale | Size | Weight | Line Height | Letter Spacing |
|---|---|---|---|---|
| **h1** | 40px | 700 | 1.2 | -0.02em |
| **h2** | 32px | 600 | 1.3 | -0.01em |
| **h3** | 24px | 600 | 1.4 | — |
| **body-lg** | 18px | 400 | 1.6 | — |
| **body-md** | 16px | 400 | 1.6 | — |
| **body-sm** | 14px | 400 | 1.5 | — |
| **label-md** | 14px | 600 | 1.2 | 0.01em |
| **label-sm** | 12px | 500 | 1.2 | — |

---

## 4. Spacing

Based on **8px grid** system.

| Token | Value |
|---|---|
| `xs` | 4px |
| `base` | 8px |
| `sm` | 12px |
| `gutter` | 16px |
| `md` / `margin` | 24px |
| `lg` | 48px |
| `xl` | 80px |

---

## 5. Shapes & Roundness

| Element | Radius |
|---|---|
| Small (chips, badges) | 4px (0.25rem) |
| Default (buttons, inputs) | 8px (0.5rem) |
| Medium (cards) | 12px (0.75rem) |
| Large (containers, modals) | 16px (1rem) |
| Extra Large | 24px (1.5rem) |
| Full (pills, avatars) | 9999px |

---

## 6. Elevation & Shadows

| Level | Usage | CSS Shadow |
|---|---|---|
| **Level 0** | Flat — background canvas | None |
| **Level 1** | Cards, content modules | `0 1px 3px rgba(0,103,71,0.04), 0 4px 8px rgba(0,103,71,0.04)` |
| **Level 2** | Active elements, dropdowns | `0 4px 12px rgba(0,103,71,0.08), 0 8px 24px rgba(0,103,71,0.06)` |
| **Level 3** | Modals, overlays | `0 8px 32px rgba(0,103,71,0.12), 0 16px 48px rgba(0,103,71,0.08)` |

> Shadows use emerald-tinted blur to prevent "dirty" look on white backgrounds.

---

## 7. Component Specifications

### Buttons
- **Primary:** `bg: #006747`, `text: white`, `radius: 8px`, `padding: 12px 24px`
- **Secondary:** `bg: #D1E7DD`, `text: #004d34`, `radius: 8px`
- **Ghost:** `bg: transparent`, `text: #006747`, `border: 1px solid #bec9c1`
- **Hover:** Darken 10% + shadow level 2
- **Disabled:** Opacity 0.5

### Cards
- `bg: #ffffff`, `radius: 12px`, `padding: 20px`
- Border: `1px solid #e5e9e4`
- Shadow: Level 1
- Optional: 4px emerald/mint top accent line
- Hover: Shadow Level 2 transition (200ms ease)

### Input Fields
- Border: `1px solid #bec9c1`
- Focus: `border-color: #006747`, `ring: 2px solid rgba(0,103,71,0.2)`
- Label: Above field, `label-md` style
- Radius: 8px
- Padding: 12px 16px

### Progress Indicators
- Track: `#e5e9e4` (surface-container-high)
- Fill: `#d1e7dd` (mint secondary-container)
- Height: 12px, fully rounded

### Navigation
- Glassmorphism: `bg: rgba(255,255,255,0.7)`, `backdrop-filter: blur(20px)`
- Material Icons: dashboard, group, fact_check, trending_up, payments
- Active tab: `color: #006747`, bottom 3px emerald accent
- Inactive tab: `color: #6f7a72`

### Toast Notifications
- Success: emerald bg variant
- Error: red bg variant
- Slide-in from top, auto-dismiss 3s

---

## 8. Islamic Pattern

- Minimalist star or interlocking hexagon grid
- Rendered as SVG background
- Stroke color: `#f1f5f0` (surface-container-low)
- Opacity: 2-5% on headers and empty states
- Never interfere with content legibility

---

## 9. Screen Map

| Screen | Vue Route | Role |
|---|---|---|
| Login | `/login` | guest |
| Welcome | `/` | guest |
| Dashboard Guru | `/guru` | guru |
| Kelola Santri | `/guru/santri` | guru |
| Input Absensi | `/guru/absensi` | guru |
| Progres Iqro | `/guru/iqro` | guru |
| Progres Sholat | `/guru/sholat` | guru |
| Pembayaran SPP | `/guru/pembayaran` | guru |
| Dashboard Wali | `/wali` | wali_santri |
| Progres Iqro Wali | `/wali/iqro` | wali_santri |
| Progres Sholat Wali | `/wali/sholat` | wali_santri |
| Presensi Wali | `/wali/presensi` | wali_santri |
| Laporan | `/wali/laporan` | wali_santri |
| Profil | `/wali/profile` | wali_santri |
