# Discovery

## Existing systems / prior art

- **Legacy:** `api/distancemultiple_indb.php` plus `api/distancemultiple_*.php` (PTV/EWS). Used from tariff_query after geocode.
- **v2:** No distance APIs.

## Constraints found

- Keep filenames and POST bodies. Out of scope: combine results (00024). depends_on: 00022.
- Cloud Run timeouts vs long PTV calls.

## Open questions

- Must PTV/EWS be live in this slice, or is cache-only (`indb`) enough until keys exist?
