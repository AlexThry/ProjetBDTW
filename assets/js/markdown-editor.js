function initMarkdownEditor() {
  const markdownEditor = document.getElementById("markdown-editor");
  if (!markdownEditor) {
    return;
  }

  const converter = new showdown.Converter({
    tables: true,
    tablesHeaderId: true,
    tasklists: true,
    simpleLineBreaks: true,
    openLinksInNewWindow: true,
    underline: true,
    strikethrough: true,
  });
  // to use github flavored markdown options
//   converter.setFlavor('github');

  markdownEditor.value = converter.makeMarkdown(markdownEditor.value);

  const previewID = markdownEditor.dataset.previewId;
  if (!previewID) {
    console.warn("No preview ID found");
    return;
  }

  const markdownPreview = document.getElementById(previewID);
  if (!markdownPreview) {
    console.warn("No preview element found");
    return;
  }

  const inputID = markdownEditor.dataset.inputId;
  if (!inputID) {
    console.warn("No input ID found");
    return;
  }

  const markdownInput = document.getElementById(inputID);
  if (!markdownInput) {
    console.warn("No input element found");
    return;
  }

  function handleInput() {
    const text = markdownEditor.value;
    const html = converter.makeHtml(text);
    markdownPreview.innerHTML = html;
    markdownInput.value = html;
  }

  markdownEditor.addEventListener("input", handleInput);
}

document.addEventListener("DOMContentLoaded", initMarkdownEditor);
