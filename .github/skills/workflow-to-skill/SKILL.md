---
name: workflow-to-skill
description: "Create a reusable SKILL.md from an existing workflow in conversation history. Use when: extracting steps, decision points, and completion criteria into a practical skill."
---

# Workflow To Skill

## Purpose

Turn a repeated process into a reusable skill file that can be invoked later.

## Inputs

- Conversation history or notes that show how work is done.
- Target outcome the skill should produce.
- Scope choice: workspace or personal.
- Format choice: quick checklist or full workflow.

## Process

### 1. Extract Workflow

Identify the process pattern from conversation context:

- Ordered steps that are repeated.
- Decision points with branching logic.
- Quality checks that define done.

If no clear pattern exists, collect missing requirements before finalizing.

### 2. Define Skill Contract

State what the skill produces:

- Primary output artifact.
- Expected quality bar.
- Typical trigger phrases in description.

### 3. Choose Scope and Location

- Workspace scope: place under .github/skills/<skill-name>/SKILL.md.
- Personal scope: use user-level customizations location.

### 4. Draft The Skill File

Include:

- YAML frontmatter with name and discovery-focused description.
- A concise purpose section.
- A numbered execution flow.
- Decision branches and edge cases.
- Completion checklist.

### 5. Validate

Check:

- YAML frontmatter parses correctly.
- Name matches folder name.
- Description includes clear trigger phrases.
- Steps are actionable and testable.

### 6. Iterate

After first draft:

- Identify ambiguous steps.
- Ask focused follow-up questions.
- Update the file to remove ambiguity.

## Decision Logic

- If workflow is obvious and repeated: draft immediately, then refine.
- If workflow is unclear: ask for outcome, scope, and depth.
- If task is simple and one-off: prefer a prompt over a skill.

## Completion Criteria

A finished skill must:

- Be discoverable via a specific description.
- Produce consistent outputs from similar prompts.
- Include at least one decision branch.
- Define explicit done checks.

## Example Prompts

- Create a skill from this bug triage workflow.
- Package our code review checklist as a reusable skill.
- Convert this implementation pattern into a team skill.
