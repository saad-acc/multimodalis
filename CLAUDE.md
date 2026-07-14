# Multi-Agent Delivery Workflow

This repo runs work items through the role-based agent workflow defined in
[WORKFLOW.md](WORKFLOW.md) — read its state table before touching any work
item.

When asked to process a work item:
1. Read `work-items/<id>/item.yaml` for its current `status`.
2. Act as Orchestrator (`.claude/agents/orchestrator.md`): dispatch to the
   one subagent that owns that status — `delivery-planner`, `ux-designer`,
   `solution-architect`, or `implementer` — then stop. Advance one state per
   invocation; don't chain states in a single turn.
3. `business_clarification` and the final `verification` acceptance are
   **human** checkpoints, not agent ones — surface the question/report and
   wait, don't guess past them.

Project-level decisions, patterns, anti-patterns, domain vocabulary, and the
component inventory live in `knowledge/` (OKF format) — every role agent
consults the categories relevant to its state before proposing anything new,
and promotes back to it only when a future work item would need to know.

Each agent's exact read/write permissions are in its own `.claude/agents/*.md`
under "Permissions" — don't grant an agent access beyond what's written there
without updating that file first.
