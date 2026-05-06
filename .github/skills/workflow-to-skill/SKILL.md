---
name: workflow-to-skill
description: "Create a reusable SKILL.md from conversation workflows. Use when extracting repeated steps, decision branches, and completion checks into an on-demand skill."
argument-hint: "What workflow should this skill capture?"
---

# Workflow To Skill

## Outcome

Produce a finalized SKILL.md plus optional support files (references, assets, scripts) that capture a reusable workflow with clear steps, decision points, and quality checks.

## Inputs

- Conversation history or notes showing how work is done.
- Target artifact the skill should produce.
- Scope preference (default: workspace scope).
- Depth choice: quick checklist or full multi-step workflow.

## Process

### 1. Review Conversation And Extract Workflow

Identify the process pattern from chat context:

- Ordered steps that are repeated.
- Decision points with branching logic.
- Quality checks that define done.

### 2. Clarify Missing Requirements If Needed

If no clear workflow is visible, ask for:

- What outcome the skill should produce.
- Whether the skill is workspace-scoped or personal.
- Whether they want a quick checklist or full workflow.

### 3. Define Skill Contract

State what the skill produces:

- Primary output artifact.
- Expected quality bar.
- Typical trigger phrases in description.

### 4. Choose Scope And Location

- Default workspace scope: place under .github/skills/<skill-name>/SKILL.md.
- If personal scope is explicitly requested: use user-level customizations location.

### 5. Draft And Save SKILL.md

Include:

- YAML frontmatter with name and discovery-focused description.
- A concise purpose section.
- A numbered execution flow.
- Decision branches and edge cases.
- Completion checklist.

Optionally scaffold support folders when useful:

- references/ for longer docs and domain rules.
- assets/ for templates and boilerplate.
- scripts/ for executable workflow helpers.

### 6. Validate Quality

Check:

- YAML frontmatter parses correctly.
- Name matches folder name.
- Description includes clear trigger phrases.
- Steps are actionable and testable.

### 7. Iterate On Ambiguity

After saving the first draft:

- Identify ambiguous steps.
- Ask focused follow-up questions.
- Update the file to remove ambiguity.

### 8. Finalize

Deliver:

- A short summary of what the skill produces.
- Example prompts to invoke the skill.
- Suggested related customizations to create next.

## Decision Logic

- If workflow is obvious and repeated: draft first, then refine.
- If workflow is unclear: clarify outcome, scope, and depth before finalizing.
- If the task is one-off and simple: prefer a prompt instead of a skill.
- If behavior should always apply: prefer instructions instead of a skill.

## Completion Criteria

A finished skill must:

- Be discoverable via a specific description.
- Produce consistent outputs from similar prompts.
- Include at least one decision branch.
- Define explicit done checks.
- Include at least two example prompts.
- Include optional support-file guidance when the workflow needs extra resources.

## Example Prompts

- Turn this deployment review process into a workspace SKILL.md with decision branches.
- Convert our bug triage checklist into a full multi-step workflow skill under .github/skills/.
- Build a workflow-to-skill package from this implementation pattern, including optional references.

## Related Customizations To Consider

- A prompt file for one-off skill scaffolding.
- File instructions for naming and frontmatter conventions.
- A custom agent for multi-stage skill authoring with validation.
