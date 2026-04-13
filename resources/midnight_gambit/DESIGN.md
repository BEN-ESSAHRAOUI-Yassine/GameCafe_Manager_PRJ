# Design System Strategy: Aji L3bo Café

## 1. Overview & Creative North Star: "The Modern Alchemist"
This design system moves away from the "bright and noisy" aesthetic of traditional gaming and leans into the sophisticated, tactile atmosphere of a high-end parlor. Our Creative North Star is **"The Modern Alchemist."** 

We are blending the ancient, social ritual of board games with a sharp, editorial digital execution. To break the "template" look, this system rejects rigid grids in favor of **intentional asymmetry** and **tonal depth**. We prioritize breathing room (white space), overlapping elements to suggest physical depth, and high-contrast typography that feels like a boutique magazine. The goal is to make the user feel they aren't just browsing a site, but entering a curated sanctuary.

---

### 2. Colors: Tonal Depth & The "No-Line" Rule
The palette is rooted in a deep, nocturnal foundation with "lit" accents that mimic the warm glow of a desk lamp over a game board.

*   **Primary (`#f2ca50` / `#d4af37`):** Use for focal points and moments of triumph.
*   **Surface Hierarchy:** Instead of a flat background, use the "Nesting" principle.
    *   **Base:** `surface` (`#131313`) for the overall canvas.
    *   **Sections:** `surface_container_low` (`#1c1b1b`) to define large content areas.
    *   **Cards/Interactive:** `surface_container_highest` (`#353534`) to draw the eye.
*   **The "No-Line" Rule:** 1px solid borders for sectioning are strictly prohibited. Boundaries must be defined by background shifts or subtle tonal transitions.
*   **The Glass & Gradient Rule:** For navigation bars or floating action buttons, use "Glassmorphism." Apply `surface_container` with a `backdrop-blur` of 12px and 60% opacity. For CTAs, use a subtle linear gradient from `primary` to `primary_container` at a 135-degree angle to add "soul" and dimension.

---

### 3. Typography: Editorial Authority
We utilize a high-contrast pairing to balance "The Alchemist’s" personality with professional readability.

*   **Display & Headlines (Epilogue):** This is our "Stylized" voice. Use `display-lg` (3.5rem) with tight letter-spacing (-0.02em) for hero sections. It should feel bold, heavy, and authoritative.
*   **Body & UI (Manrope):** A high-performance sans-serif. Manrope provides a clean, technical counterpoint to the expressive headlines.
    *   **Hierarchy:** `title-lg` for card titles; `body-md` for general descriptions; `label-sm` for technical metadata (e.g., game duration, player count).
*   **Editorial Spacing:** Always provide 1.5x line-height for body text to ensure the "Cozy" brand pillar is felt through legibility and air.

---

### 4. Elevation & Depth: Tonal Layering
Traditional shadows often look "dirty" on dark UI. We achieve depth through light and layering.

*   **The Layering Principle:** Stack surfaces like physical game boards. A `surface_container_lowest` card sitting on a `surface_container_low` section creates a natural, soft "lift" without a single shadow.
*   **Ambient Glow:** When an element must "float" (like a Modal), use a shadow with a 40px blur, 0% spread, and 8% opacity. Use the `surface_tint` (`#e9c349`) as the shadow color rather than black; this mimics the warm ambient light of the café.
*   **The Ghost Border:** If containment is needed for accessibility, use a "Ghost Border": `outline_variant` at 15% opacity. Never use 100% opaque lines.

---

### 5. Components: Tactile Minimalism

*   **Buttons:**
    *   **Primary:** `primary_fixed` background with `on_primary_fixed` text. 0.75rem (`md`) corner radius.
    *   **Secondary:** Glassmorphic background with a `ghost-border`.
*   **Cards:** Forbid the use of divider lines. Use `vertical white space` (minimum 32px) and `surface-container` shifts to separate the game image from the game description.
*   **Input Fields:** Use `surface_container_high` as the fill. On focus, transition the "Ghost Border" from 15% to 100% opacity of the `primary` color. Corners should be `DEFAULT` (0.5rem).
*   **Chips (Game Categories):** Use `secondary_container` with `label-md`. They should look like high-quality tokens or game pieces.
*   **The "Game Tracker" (Contextual Component):** A bespoke progress bar for booking or game status using a gradient of `primary` to `surface_tint`.

---

### 6. Do’s and Don’ts

#### Do:
*   **Asymmetry:** Place a large headline overlapping the edge of a card to create a high-end editorial look.
*   **Breathing Room:** If you think there’s enough space, add 16px more. Luxury is defined by unused space.
*   **Subtle Warmth:** Ensure all "neutral" greys are slightly warm-tinted (`surface_variant`) to maintain the "Cozy" promise.

#### Don’t:
*   **Don’t use pure black (#000):** It feels "dead." Always use the system’s `surface` depth.
*   **Don’t use standard "Drop Shadows":** They break the alchemist aesthetic. Use tonal layering or ambient glows.
*   **Don’t use 1px dividers:** They create visual clutter. Use the spacing scale and background shifts to define hierarchy.
*   **Don’t cram content:** If a card feels full, break the content into a "Nested" surface hierarchy.