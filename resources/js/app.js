import "@tailwindplus/elements";

Alpine.magic("clipboard", () => {
    return (subject) => navigator.clipboard.writeText(subject);
});
