---
name: Islamic Education Design System
colors:
  surface: '#f7faf5'
  surface-dim: '#d7dbd6'
  surface-bright: '#f7faf5'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f1f5f0'
  surface-container: '#ebefea'
  surface-container-high: '#e5e9e4'
  surface-container-highest: '#e0e3df'
  on-surface: '#181d1a'
  on-surface-variant: '#3f4943'
  inverse-surface: '#2d312e'
  inverse-on-surface: '#eef2ed'
  outline: '#6f7a72'
  outline-variant: '#bec9c1'
  surface-tint: '#0b6c4b'
  primary: '#004d34'
  on-primary: '#ffffff'
  primary-container: '#006747'
  on-primary-container: '#8fe2ba'
  inverse-primary: '#84d7af'
  secondary: '#4f635b'
  on-secondary: '#ffffff'
  secondary-container: '#d1e7dd'
  on-secondary-container: '#556961'
  tertiary: '#3d4446'
  on-tertiary: '#ffffff'
  tertiary-container: '#545b5d'
  on-tertiary-container: '#ccd3d5'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#a0f4ca'
  primary-fixed-dim: '#84d7af'
  on-primary-fixed: '#002114'
  on-primary-fixed-variant: '#005137'
  secondary-fixed: '#d1e7dd'
  secondary-fixed-dim: '#b6cbc2'
  on-secondary-fixed: '#0c1f19'
  on-secondary-fixed-variant: '#374b44'
  tertiary-fixed: '#dde4e6'
  tertiary-fixed-dim: '#c1c8ca'
  on-tertiary-fixed: '#161d1f'
  on-tertiary-fixed-variant: '#41484a'
  background: '#f7faf5'
  on-background: '#181d1a'
  surface-variant: '#e0e3df'
typography:
  h1:
    fontFamily: Plus Jakarta Sans
    fontSize: 40px
    fontWeight: '700'
    lineHeight: '1.2'
    letterSpacing: -0.02em
  h2:
    fontFamily: Plus Jakarta Sans
    fontSize: 32px
    fontWeight: '600'
    lineHeight: '1.3'
    letterSpacing: -0.01em
  h3:
    fontFamily: Plus Jakarta Sans
    fontSize: 24px
    fontWeight: '600'
    lineHeight: '1.4'
  body-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 18px
    fontWeight: '400'
    lineHeight: '1.6'
  body-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 16px
    fontWeight: '400'
    lineHeight: '1.6'
  body-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 14px
    fontWeight: '400'
    lineHeight: '1.5'
  label-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 14px
    fontWeight: '600'
    lineHeight: '1.2'
    letterSpacing: 0.01em
  label-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 12px
    fontWeight: '500'
    lineHeight: '1.2'
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  base: 8px
  xs: 4px
  sm: 12px
  md: 24px
  lg: 48px
  xl: 80px
  gutter: 16px
  margin: 24px
---

## Brand & Style

The design system is anchored in the principles of clarity, tranquility, and academic excellence. It aims to bridge the gap between traditional Islamic values and modern educational technology, creating an environment that feels both sacred and highly functional. 

The aesthetic is **Minimalist and Modern**, prioritizing high whitespace to reduce cognitive load for busy parents and teachers. The inclusion of subtle geometric patterns provides a cultural resonance without distracting from the educational content. The interface should feel "breathable," utilizing a light-flooded layout that evokes a sense of peace and professional reliability.

## Colors

The palette is led by **Emerald Green**, symbolizing growth and tradition, used strategically for primary actions and brand presence. A **Mint accent** provides a refreshing contrast, used for highlights and secondary interactive elements. 

The background utilizes **Pure White** and **Very Light Gray** to establish a clean, editorial feel. Semantic colors (success, warning, error) should be slightly desaturated to maintain the sophisticated, professional tone of the system.

## Typography

The design system utilizes **Plus Jakarta Sans** for its friendly yet professional geometric construction. The typeface provides excellent legibility for long-form educational text while remaining stylish for headings.

Hierarchy is established through weight and size rather than color variation. Headings should be tight and bold, while body text requires generous line-height to ensure readability for parents reviewing progress reports and teachers managing student data.

## Layout & Spacing

This design system follows a **12-column fluid grid** for desktop and a **4-column grid** for mobile. A strict 8px spatial scale governs all padding and margins to ensure a consistent rhythmic flow.

Whitespace is used as a functional tool to separate distinct modules of information, such as student profiles and lesson plans. Layouts should favor center-aligned content containers for a balanced, focused experience.

## Elevation & Depth

Visual hierarchy is achieved through **ambient shadows** and **tonal layering**. Shadows should be extremely soft, utilizing a primary-tinted blur (e.g., a hint of Emerald in the shadow color) to prevent a "dirty" look on white backgrounds.

Depth is used to distinguish interactive layers:
- **Level 0 (Flat):** Main background and canvas.
- **Level 1 (Subtle):** Cards and content modules using a 1px border or a very soft 4px blur shadow.
- **Level 2 (Active):** Modals, dropdowns, and buttons in an active state, utilizing a more pronounced 12px blur shadow.

## Shapes

The shape language is defined by **soft, approachable curves**. A standard corner radius of 0.5rem (8px) is applied to most components, while larger containers like cards use 1rem (16px).

Islamic geometric patterns should be used as background masks or subtle watermarks. These patterns must be simplified and "ghosted" (opacity between 2% and 5%) to ensure they never interfere with content legibility. All iconography should follow a consistent line-weight that matches the typography’s medium weight.

## Components

### Buttons
- **Primary:** Solid Emerald (#006747) with white text. High-contrast and professional.
- **Secondary:** Mint background (#D1E7DD) with Emerald text. Used for secondary actions like "Save Draft."
- **Ghost:** No background, Emerald text. Used for navigation or less critical actions.

### Cards
Cards are the primary container for student and lesson data. They should feature a white background, a very light gray border (#E9ECEF), and a subtle shadow. The top edge can optionally feature a 4px Mint or Emerald accent line to categorize content.

### Input Fields
Inputs should be clean with a 1px light gray stroke that turns Emerald on focus. Labels must be placed above the field in `label-md` style for maximum clarity.

### Progress Indicators
Given the educational context, progress bars should use the Mint accent color to denote completion, providing a sense of positive reinforcement for students and parents.

### Modern Islamic Patterns
Incorporate a subtle "Darul Ikhlas" pattern as a background element in headers or empty states. The pattern should be a minimalist star or interlocking hexagon grid, rendered in a very light stroke color (#F1F3F5).