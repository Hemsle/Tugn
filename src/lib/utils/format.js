export function formatOption(str) {
    if (!str) return "";
    return str
        .replace(/_/g, ' ')
        .replace(/-/g, '')        // Byt ut understreck mot mellanslag
        .replace(/\b\w/g, c => c.toUpperCase()); // Gör första bokstaven i varje ord stor
}