# Discovery

## Existing systems / prior art

- **v2:** No user admin.
- **Legacy:** `user_management` → `views/user_management.php` → `get_users_ajax`, `save_user`, `delete_user`, `user_toggle_status`, `resend_invite`, `export_users_excel`; invite mail `templates/email_user_invite.php` + Mailer.

## Constraints found

- Keep those `/api/` names. Out of scope: role matrix (00018). depends_on: 00003, 00004; mail for invites.

## Open questions

- Same as 00010: is invite email required in this slice or can resend_invite 501 until mail ops exists?
