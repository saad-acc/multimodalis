---
type: Feature
title:
description:
resource:                 # path to the entry point in source (route, command, menu)
tags: []
timestamp:
---

# Sub-features
Short IDs, one line each, for each distinct behavior this feature covers.

# How to get to it (user POV)
Every user entry point — button, keyboard shortcut, CLI command, route.
No implementation detail, only what a user actually touches.

# Driving it with <harness>
Preconditions, then labeled steps that pair each user action with an exact
command (from `knowledge/features/index.md`'s harness) and the observable
result that proves it happened. See `knowledge/features/index.md` for the
harness conventions this must follow.

# Gotchas
Traps that waste or invalidate a verification run (timing, focus, trimming,
state that must be restored).
