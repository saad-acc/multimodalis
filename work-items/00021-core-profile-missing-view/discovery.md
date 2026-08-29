# Discovery

## Existing systems / prior art

- **v2:** No `profile` slug.
- **Legacy:** `$allowed_pages` registers `profile` → `views/profile.php`. **File is missing** in modal `views/` (feature map shell-auth). Company details live on `profile_company` (00016). Hitting the slug today is an include failure / 404-class error, not a designed UI.

## Constraints found

- Request: do not invent a profile product; human chooses 404, hide nav, or add a view.
- depends_on: 00002. Out of scope: replacing profile_company.

## Open questions

- What should `?page=profile` do on Multimodalis: match modal’s broken include, hide nav + 404, redirect to `profile_company`, or add a new view later?
