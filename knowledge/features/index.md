# Feature map

The maintained, live-verifiable inventory of the product's user-facing
behavior — one file per feature (`templates/knowledge/feature.md`), plus the
harness conventions below. This is what `verification` drives against
instead of self-reporting, and what `implementer`'s feature-map maintenance
pass keeps honest as the app changes.

## Harness

*Not yet seeded.* The first work item whose `verification` needs to drive a
real user-facing feature fills this section in (see `implementer.md`'s
Verification step): how to launch the app for verification, one read-only
doctor check, how to drive it (browser/CLI/API — whichever surfaces exist),
where evidence gets captured, and how to clean up. Once filled in, every
feature file's "Driving it with `<harness>`" section refers back to these
conventions instead of restating them.

## Features
*None captured yet.* Each work item's `verification` adds or updates one
entry here for any user-facing feature it created or changed materially
enough that the old recipe would no longer prove it works.
