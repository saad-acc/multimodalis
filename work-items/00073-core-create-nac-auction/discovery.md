# Discovery

## Existing systems / prior art

- **Legacy:** `create_nac_auction` → `views/create_nac_auction.php` → `save_nac_auctions`, `save_nac_relations`, `save_nac_round_recipients`, `send_nac_invitations`, `fetch_nac_summary`. Mailer. depends_on: 00003, 00006.

## Open questions

- Must invitation mail send in this slice (SMTP) like 00017?
