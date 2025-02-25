import './editor';
import './tabs';
import './shortcode';

document.addEventListener('DOMContentLoaded', () => {
	const form = document.getElementById('snippet-form');
	const editor = window.code_snippets_editor.codemirror;
	const strings = window.code_snippets_edit_i18n;
	const snippet_name = document.querySelector('input[name=snippet_name]') as HTMLInputElement;

	if (!form || !editor || !snippet_name) return;

	form.addEventListener('submit', (event: SubmitEvent) => {
		const missing_title = '' === snippet_name.value.trim();
		const missing_code = '' === editor.getValue().trim();

		const message = missing_title ?
			missing_code ? strings.missing_title_code : strings.missing_title :
			missing_code ? strings.missing_code : '';

		if (event.submitter.id.startsWith('save_snippet') && message && !confirm(message)) {
			event.preventDefault();
		}
	});
});
