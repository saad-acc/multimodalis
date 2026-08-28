# Verification Report

## Automated
| Check | Command | Result |
|---|---|---|
| Build | | pass/fail |
| Lint | | pass/fail |
| Tests | | pass/fail |

## Conformance
- vs. `architecture.md`: match / drift (describe)
- vs. `ux-spec.md`: match / drift (describe)
- vs. accepted `knowledge/decisions/`: match / drift (describe)

## Live verification
| Feature (`knowledge/features/`) | Driven? | Evidence |
|---|---|---|
| | proven / not proven / n/a (no user-facing surface touched) | path |

## Documentation hygiene
| Check | Status |
|---|---|
| Flagged `knowledge/` promotions written | done / n/a |
| Drift from plan reconciled in `knowledge/` + work-item artifacts | done / n/a |
| New components captured in `knowledge/components/` | done / n/a |
| Feature map (`knowledge/features/`) current for every touched feature | done / n/a |
| No dangling question in `clarifications.md` | done |
| `knowledge/log.md` entry per promotion | done / n/a |

## Verdict
pass → `done` (pending human acceptance)
fail → rework target: `implementation` | `architecture_input` | `ux_input` | `discovery`

If target is `discovery`: what was learned, and what already exists, so
Delivery Planner refines instead of re-discovering it from scratch.

## Human acceptance
**Accepted by:**
**Date:**
