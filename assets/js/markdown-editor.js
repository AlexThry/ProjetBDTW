function initMarkdownEditor() {
  const markdownEditor = document.getElementById("markdown-editor");
  if (!markdownEditor) {
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

  const initialHTML = markdownEditor.value;
  markdownEditor.value = converter.makeMarkdown(initialHTML);

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

  markdownInput.value = initialHTML;

  /**
   * Enable to fix a showdown bug due to html snippets.
   *
   * @param string str
   * @returns
   */
  function decode(str) {
    return str
      // .replaceAll("&lt;", "<")
      // .replaceAll("&gt;", ">")
      // .replaceAll("&amp;", "&")
      // .replaceAll("&quot;", '"')
      // .replaceAll("&apos;", "'");
  }

  function handleInput() {
    const text = markdownEditor.value;
    const html = decode(converter.makeHtml(text));
    markdownPreview.innerHTML = html;
    markdownInput.value = html;
  }

  markdownEditor.addEventListener("input", handleInput);
}

document.addEventListener("DOMContentLoaded", initMarkdownEditor);
