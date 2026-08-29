# Anti-patterns

Approaches already tried or proposed for *this* project and rejected, with
why. Existing to stop the same rejected idea resurfacing in a later work
item. Not generic industry anti-patterns — only ones specific to this
project's context.

# Architecture
- [Invent credentials or flip AUTH_MODE=db before Better Auth](invent-credentials-or-early-db-auth.md) — no invented DB secrets; no db-login / attach flip until Better Auth (`00005`)
