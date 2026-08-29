# Discovery

## Existing systems / prior art

- **v2:** No register page.
- **Legacy:** `$public_pages` includes `register`. View `views/register.php` posts to itself (PDO), invite token via `nac_round_recipients.invitation_token` or self-signup email. Not a separate `/api/register.php`.
- **Feature map:** Not a dedicated shell-auth subsection; still a public slug.

## Constraints found

- Keep `?page=register`. Out of scope: changing invite-only policy vs modal (modal supports both invite token and self-signup).
- depends_on: 00002; 00006 if writing `users`. NAC tables for invite path.

## Open questions

- Should v2 keep open self-signup (no token) as modal does, or restrict to invite-only for Multimodalis?
