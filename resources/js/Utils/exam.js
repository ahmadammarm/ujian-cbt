// Mirrors the server-side pass mark (KKM) used by AnalyticsService and the result page
export const PASSING_SCORE = 70;

export const isPassing = (score) => Number(score) >= PASSING_SCORE;

export const formatDate = (value, options = { day: 'numeric', month: 'long', year: 'numeric' }) => {
    if (!value) return '–';
    return new Date(value).toLocaleDateString('id-ID', options);
};

export const formatDateTime = (value) => {
    if (!value) return '–';
    return new Date(value).toLocaleString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};
