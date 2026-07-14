---
okf_version: "0.1"
---

# Project Knowledge

This is project **state**, not work-item history: what's already decided,
what to reuse, what's already been rejected, and the vocabulary in use.
Every role agent reads the relevant category below before proposing
anything new in a work item, and writes back here when a work item
produces something that should outlive it (see `WORKFLOW.md` §
"Project-level knowledge"). Work-item-specific detail stays in
`work-items/<id>/` — it never gets promoted here unless it's true beyond
that one item.

# Categories

* [Architecture Decisions](decisions/) - accepted/superseded decisions new work must conform to
* [Patterns](patterns/) - established reusable approaches (architecture and UX)
* [Anti-patterns](anti-patterns/) - approaches already tried and rejected, and why
* [Domain Concepts](domain/) - shared vocabulary / glossary
* [Components](components/) - inventory of existing systems/modules
