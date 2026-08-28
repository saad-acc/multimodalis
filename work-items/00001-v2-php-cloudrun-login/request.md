# Request

**Submitted by:** human
**Date:** 2026-08-28

## Problem statement
this repo is about a second version of an existing PHP application (php:8.3-apache) that will run on GCP cloudrun and in the same GCP Project will have a CloudSQL (mysql) database connection.

For now, use the Browser to go to sandbox.bestmodal.de to see the login flow (i will help authenticate) and the first page UI.

Then this needs to be implemented in our codebase here.

Then I need to be able to test it when deployed locally, then test again when deployed on cloudrun but after we've set up github actions to trigger the GCP deploy to cloudrun when a version `v0.0.1` tag is given.

## Why now
Human asked Orchestrator to start this work item from the live sandbox as the UI/source of truth.

## Known constraints (if any)
- Runtime: php:8.3-apache
- Hosting: GCP Cloud Run
- Database: Cloud SQL (MySQL) in the same GCP project
- First slice: login flow + first page UI as seen on https://sandbox.bestmodal.de
- Local deploy must be testable
- GitHub Actions must deploy to Cloud Run when a `v0.0.1` tag is given
