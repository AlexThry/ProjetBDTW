function initMarkdownEditors() {
  const markdownEditors = document.querySelectorAll(".markdown-editor-container");
  if (!markdownEditors) {
    return;
  }

  const unescapeAngleBrackets = [
    {
      type: "output",
      regex: new RegExp(`&lt;`, "g"),
      replace: `\<`,
    },
    {
      type: "output",
      regex: new RegExp(`&gt;`, "g"),
      replace: `\>`,
    },
  ];

  // cause issues when we try to update questions
  // showdown.extension("highlight", function () {
  //   return [
  //     {
  //       type: "output",
  //       filter: function (text, converter, options) {
  //         var left = "<pre><code\\b[^>]*>",
  //           right = "</code></pre>",
  //           flags = "g";
  //         var replacement = function (wholeMatch, match, left, right) {
  //           var lang = (left.match(/class=\"([^ \"]+)/) || [])[1];
  //           left = left.slice(0, 18) + "hljs " + left.slice(18);
  //           if (lang && hljs.getLanguage(lang)) {
  //             return left + hljs.highlight(lang, match).value + right;
  //           } else {
  //             return left + hljs.highlightAuto(match).value + right;
  //           }
  //         };
  //         return showdown.helper.replaceRecursiveRegExp(
  //           text,
  //           replacement,
  //           left,
  //           right,
  //           flags
  //         );
  //       },
  //     },
  //   ];
  // });

  const converter = new showdown.Converter({
    tables: true,
    tablesHeaderId: true,
    tasklists: true,
    simpleLineBreaks: true,
    openLinksInNewWindow: true,
    underline: true,
    strikethrough: true,
    // extensions: ["highlight"],
    ghCodeBlocks: true,
    smoothLivePreview: true,
    smartIndentationFix: true,
    requireSpaceBeforeHeadingText: true,
    ghMentions: true,
    backslashEscapesHTMLTags: true,
    emoji: true,
    ellipsis: true,
  });
  // to use github flavored markdown options
  //   converter.setFlavor('github');

  for(const markdownEditor of markdownEditors) {

    // Search for the renderer preview
    const markdownTextArea = markdownEditor.querySelector("textarea");
    if (!markdownTextArea) {
      console.warn("No text area element found");
      return;
    }

    const initialHTML = markdownTextArea.value;
    markdownTextArea.value = converter.makeMarkdown(initialHTML);

    // Search for the renderer preview
    const markdownPreview = markdownEditor.querySelector(".html-markdown-renderer");
    if (!markdownPreview) {
      console.warn("No preview element found");
      return;
    }

    // Search for the renderer input
    const markdownInput = markdownEditor.querySelector(".html-input");
    if (!markdownInput) {
      console.warn("No input element found");
      return;
    }

    // console.log(markdownInputClass, markdownPreviewClass);

    markdownInput.value = initialHTML;

    function handleInput() {
      const text = markdownTextArea.value;
      const html = converter.makeHtml(text);
      markdownPreview.innerHTML = html;
      markdownInput.value = html;
    }

    markdownTextArea.addEventListener("input", handleInput);
  }
}

document.addEventListener("DOMContentLoaded", initMarkdownEditors);
