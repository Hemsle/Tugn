export function formatOption(str) {
    if (!str) return "";
    return str
        .replace(/_/g, ' ')     // Byt ut understreck mot mellanslag
            
        .replace(/\b\w/g, c => c.toUpperCase()); // Gör första bokstaven i varje ord stor
}

export function getTimeAgo(date) {
    const now = new Date();
    const battleTime = new Date(date);
    const diffInSeconds = Math.floor((now - battleTime) / 1000);
    
    const diffInMinutes = Math.floor(diffInSeconds / 60);
    const diffInHours = Math.floor(diffInMinutes / 60);
    const diffInDays = Math.floor(diffInHours / 24);

    if (diffInHours < 24) return `Today`;
    if (diffInDays === 1) return 'Yesterday';
    if (diffInDays < 7) return `${diffInDays} days ago`;
    if (diffInDays < 30) return `${Math.floor(diffInDays / 7)} week${Math.floor(diffInDays / 7) > 1 ? 's' : ''} ago`;
    if (diffInDays < 365) return `${Math.floor(diffInDays / 30)} month${Math.floor(diffInDays / 30) > 1 ? 's' : ''} ago`;
    
    const diffInYears = Math.floor(diffInDays / 365);
    return `${diffInYears} year${diffInYears > 1 ? 's' : ''} ago`;
}