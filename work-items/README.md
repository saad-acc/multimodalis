# Work items

One folder per work item: `work-items/<id>-<slug>/`, copied from `templates/`.
`item.yaml.status` drives everything — see `WORKFLOW.md` for the state
machine and `.claude/agents/` for what each role does at each state.

To start a new item:
```
mkdir work-items/<id>-<slug>
cp templates/item.yaml templates/request.md work-items/<id>-<slug>/
```
Fill in `request.md`, set `item.yaml` status to `requested`, then run the
Orchestrator.
