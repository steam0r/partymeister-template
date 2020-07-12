#!/usr/bin/env bash
package-json-merge package.json.base \
packages/motor-cms/resources/assets/npm/package.json \
packages/motor-backend/resources/assets/npm/package.json \
packages/motor-docs/resources/assets/npm/package.json \
packages/partymeister-accounting/resources/assets/npm/package.json \
packages/partymeister-frontend/resources/assets/npm/package.json \
packages/partymeister-slides/resources/assets/npm/package.json \
> package.json
