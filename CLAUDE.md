# ChurchCRM Development Guide

This file is loaded by Claude Code for every session. Follow these instructions for all work on this project.

---

## Skills System

Structured development skills live in `.agents/skills/`. **Always consult the relevant skill before starting work.**

- **Index**: [`.agents/skills/churchcrm/SKILL.md`](.agents/skills/churchcrm/SKILL.md) — use this to find the right skill for your task
- **Generic skills**: `gh-cli`, `interface-design`, `php-best-practices`, `web-design-guidelines` (see `.agents/skills/`)

### Skill Selection by Task

| Task type | Skills to read |
|-----------|---------------|
| New API endpoint | `api-development.md` → `service-layer.md` → `slim-4-best-practices.md` → `security-best-practices.md` |
| Migrate legacy page | `routing-architecture.md` → `admin-mvc-migration.md` → `frontend-development.md` |
| Database / ORM work | `database-operations.md` → `db-schema-migration.md` |
| UI / frontend changes | `bootstrap-adminlte.md` → `frontend-development.md` → `webpack-typescript.md` |
| i18n / translations | `i18n-localization.md` → `frontend-development.md` |
| Security issue | `security-best-practices.md` → `authorization-security.md` |
| Plugin work | `plugin-system.md` → `plugin-development.md` |
| Testing | `testing.md` → `cypress-testing.md` |
| Commit / PR | `git-workflow.md` → `github-interaction.md` |
| Refactor | `refactor.md` → `service-layer.md` |
| Performance | `performance-optimization.md` → `database-operations.md` |
| Configuration | `configuration-management.md` |

---

## Auto-Learning: Proactive Skill Updates

**IMPORTANT: Agents must update skill files automatically when they learn something new — no user prompt required.**

### When to Update Skills

Update the relevant skill file immediately when you:
- Discover a pattern, API, or convention not yet documented
- Find a bug, gotcha, or anti-pattern worth warning others about
- Solve a recurring problem with a reusable solution
- Confirm that documented guidance is wrong or outdated
- Encounter a new file, class, or service that belongs in the architecture overview

### What Qualifies as "New Learning"

- A class, utility, or helper you had to search for (others will too)
- A constraint you violated and had to fix (e.g., wrong Bootstrap class, missing cast)
- An edge case in Propel ORM, Slim 4, or AdminLTE not in existing docs
- A build/test step that's easy to forget
- A new module, route group, or architectural pattern added to the codebase

### What Does NOT Qualify

- Trivialities already covered in existing skill files
- Task-specific context (e.g., "today I fixed issue #1234")
- Speculation — only write confirmed, tested facts
- Anything that duplicates existing documented guidance

### How to Update

1. **Identify the right skill file** from `.agents/skills/churchcrm/SKILL.md`
2. **Edit the skill file** — add a clearly labelled subsection with a short explanation + code example
3. **If it's a new category**, add a row to the table in `.agents/skills/churchcrm/SKILL.md`
4. **Keep it concise** — one paragraph max, prefer code examples over prose
5. **Date the entry** — append `<!-- learned: YYYY-MM-DD -->` as an HTML comment on the section header line

### Example Auto-Update (what to write)

```markdown
### Casting Foreign Keys in Propel Relations <!-- learned: 2026-02-28 -->

When traversing Propel relations via `->getXxx()`, always cast the FK to `(int)`
before passing to query methods — Propel does not auto-cast string inputs from
`$_POST`/route params.

```php
// ✅ CORRECT
$group = GroupQuery::create()->findPk((int)$groupId);

// ❌ WRONG — silently returns null when $groupId is a string "42"
$group = GroupQuery::create()->findPk($groupId);
```
```

### Memory File Sync

After updating a skill file, also check if [`.claude/projects/.../memory/MEMORY.md`] needs a one-line summary added under **Critical Patterns**.

---

## Always-Apply Standards

These rules apply to **every code change** in this project.

@.agents/skills/churchcrm/code-standards.md

---

## Mandatory Code Review Before Any Commit

**NEVER commit or push without first showing the user the diff and getting explicit approval.**

This applies even when the user asks you to "fix" or "make changes" — finishing the code is not permission to commit.

### Required sequence for every commit:

1. Make the changes
2. Run `git diff` and show the output to the user
3. Explicitly ask: *"Please review the changes above. Shall I commit?"*
4. Wait for explicit approval (e.g. "yes", "looks good", "commit it")
5. Only then run `git add` + `git commit` + `git push`

### What counts as explicit approval

✅ "yes", "looks good", "lgtm", "commit it", "go ahead", "ship it"

❌ Silence, continuing the conversation, asking follow-up questions — these are NOT approval

### No exceptions

Even if you are confident the changes are correct, even if the user said "fix the bug" — always show the diff and wait for approval before committing.

---

## Git & PR Workflow

@.agents/skills/churchcrm/git-workflow.md

---

## Test Review & Commit Workflow

**MANDATORY: Always test changes to test files BEFORE committing.**

When fixing a failed test:

1. **Run the failing test in isolation** — use `--spec` flag to test only that file
2. **Identify root cause** — check logs, API responses, or browser errors
3. **Update relevant skills** — if you discover a pattern, add it with `<!-- learned: YYYY-MM-DD -->`
4. **Update master SKILL.md** — if it's a new testing category, add row to skill index
5. **Commit with documentation**:
   ```
   test: fix {test name} - {reason}

   - Root cause: {what was wrong}
   - Fix: {what changed}
   - Updated: cypress-testing.md with {pattern/learning}
   - Requires: Docker|Local environment
   ```

### Test-Related Skills to Update

- `cypress-testing.md` — API patterns, session setup, data handling
- `database-operations.md` — ORM query patterns
- `webpack-typescript.md` — React/component patterns
- `code-standards.md` — General best practices

**Remember: Skills get documented the moment you learn something. Never defer skill updates.**

---

## Mandatory Pre-Commit Checklist

**NEVER commit or push without completing ALL of the following steps in order.**

### Required sequence for every commit:

1. Make the changes
2. **Run `npm run lint`** — catches Biome lint errors before CI does
3. **Run `npm run build`** — full build: PHP syntax + TypeScript compilation + Biome format
4. Fix any errors reported by steps 2–3 before continuing
5. Run `git diff` and show the full output to the user
6. Ask: *"Build and lint passed. Please review the changes above. Shall I commit?"*
7. Wait for explicit approval — "yes", "looks good", "lgtm", "commit it", "go ahead", "ship it"
8. Only then: `git add` → `git commit` → `git push`

### What each command validates

| Command | Validates |
|---------|-----------|
| `npm run lint` | Biome lint rules — type safety, hook deps, correctness (`react/`) |
| `npm run build` | TypeScript types (webpack), PHP syntax, Biome format |

### No exceptions

- Do not skip build/lint even for "small" or "obvious" fixes
- Do not commit even when the user says "fix it" — build + review first
- Silence or follow-up questions from the user are NOT approval to commit

<!-- gitnexus:start -->
# GitNexus — Code Intelligence

This project is indexed by GitNexus as **ministry-master** (12975 symbols, 40279 relationships, 300 execution flows). Use the GitNexus MCP tools to understand code, assess impact, and navigate safely.

> If any GitNexus tool warns the index is stale, run `npx gitnexus analyze` in terminal first.

## Always Do

- **MUST run impact analysis before editing any symbol.** Before modifying a function, class, or method, run `gitnexus_impact({target: "symbolName", direction: "upstream"})` and report the blast radius (direct callers, affected processes, risk level) to the user.
- **MUST run `gitnexus_detect_changes()` before committing** to verify your changes only affect expected symbols and execution flows.
- **MUST warn the user** if impact analysis returns HIGH or CRITICAL risk before proceeding with edits.
- When exploring unfamiliar code, use `gitnexus_query({query: "concept"})` to find execution flows instead of grepping. It returns process-grouped results ranked by relevance.
- When you need full context on a specific symbol — callers, callees, which execution flows it participates in — use `gitnexus_context({name: "symbolName"})`.

## When Debugging

1. `gitnexus_query({query: "<error or symptom>"})` — find execution flows related to the issue
2. `gitnexus_context({name: "<suspect function>"})` — see all callers, callees, and process participation
3. `READ gitnexus://repo/ministry-master/process/{processName}` — trace the full execution flow step by step
4. For regressions: `gitnexus_detect_changes({scope: "compare", base_ref: "main"})` — see what your branch changed

## When Refactoring

- **Renaming**: MUST use `gitnexus_rename({symbol_name: "old", new_name: "new", dry_run: true})` first. Review the preview — graph edits are safe, text_search edits need manual review. Then run with `dry_run: false`.
- **Extracting/Splitting**: MUST run `gitnexus_context({name: "target"})` to see all incoming/outgoing refs, then `gitnexus_impact({target: "target", direction: "upstream"})` to find all external callers before moving code.
- After any refactor: run `gitnexus_detect_changes({scope: "all"})` to verify only expected files changed.

## Never Do

- NEVER edit a function, class, or method without first running `gitnexus_impact` on it.
- NEVER ignore HIGH or CRITICAL risk warnings from impact analysis.
- NEVER rename symbols with find-and-replace — use `gitnexus_rename` which understands the call graph.
- NEVER commit changes without running `gitnexus_detect_changes()` to check affected scope.

## Tools Quick Reference

| Tool | When to use | Command |
|------|-------------|---------|
| `query` | Find code by concept | `gitnexus_query({query: "auth validation"})` |
| `context` | 360-degree view of one symbol | `gitnexus_context({name: "validateUser"})` |
| `impact` | Blast radius before editing | `gitnexus_impact({target: "X", direction: "upstream"})` |
| `detect_changes` | Pre-commit scope check | `gitnexus_detect_changes({scope: "staged"})` |
| `rename` | Safe multi-file rename | `gitnexus_rename({symbol_name: "old", new_name: "new", dry_run: true})` |
| `cypher` | Custom graph queries | `gitnexus_cypher({query: "MATCH ..."})` |

## Impact Risk Levels

| Depth | Meaning | Action |
|-------|---------|--------|
| d=1 | WILL BREAK — direct callers/importers | MUST update these |
| d=2 | LIKELY AFFECTED — indirect deps | Should test |
| d=3 | MAY NEED TESTING — transitive | Test if critical path |

## Resources

| Resource | Use for |
|----------|---------|
| `gitnexus://repo/ministry-master/context` | Codebase overview, check index freshness |
| `gitnexus://repo/ministry-master/clusters` | All functional areas |
| `gitnexus://repo/ministry-master/processes` | All execution flows |
| `gitnexus://repo/ministry-master/process/{name}` | Step-by-step execution trace |

## Self-Check Before Finishing

Before completing any code modification task, verify:
1. `gitnexus_impact` was run for all modified symbols
2. No HIGH/CRITICAL risk warnings were ignored
3. `gitnexus_detect_changes()` confirms changes match expected scope
4. All d=1 (WILL BREAK) dependents were updated

## Keeping the Index Fresh

After committing code changes, the GitNexus index becomes stale. Re-run analyze to update it:

```bash
npx gitnexus analyze
```

If the index previously included embeddings, preserve them by adding `--embeddings`:

```bash
npx gitnexus analyze --embeddings
```

To check whether embeddings exist, inspect `.gitnexus/meta.json` — the `stats.embeddings` field shows the count (0 means no embeddings). **Running analyze without `--embeddings` will delete any previously generated embeddings.**

> Claude Code users: A PostToolUse hook handles this automatically after `git commit` and `git merge`.

## CLI

- Re-index: `npx gitnexus analyze`
- Check freshness: `npx gitnexus status`
- Generate docs: `npx gitnexus wiki`

<!-- gitnexus:end -->
