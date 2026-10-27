// Chart colors mirror the study-desk tokens in tailwind.config.js.
// INK_MARK + PEN were checked with the dataviz palette validator (lightness, CVD, contrast).
export const CHART_COLORS = {
    inkMark: '#3D53A6',
    pen: '#C8323F',
    inkSoft: '#4A5683',
    rule: '#CFE0F3',
    paper: '#FBFCFE',
};

export const CHART_FONT = '"Atkinson Hyperlegible", ui-sans-serif, system-ui, sans-serif';

const axis = {
    border: { display: false },
    grid: { color: CHART_COLORS.rule, drawTicks: false },
    ticks: { color: CHART_COLORS.inkSoft, padding: 8, font: { family: CHART_FONT, size: 12 } },
};

export const baseChartOptions = (overrides = {}) => ({
    responsive: true,
    maintainAspectRatio: false,
    animation: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? false : undefined,
    plugins: {
        legend: { display: false },
        tooltip: {
            backgroundColor: '#1B2A6B',
            titleFont: { family: CHART_FONT, weight: 'bold' },
            bodyFont: { family: CHART_FONT },
            padding: 10,
            cornerRadius: 6,
            displayColors: false,
        },
    },
    scales: {
        x: { ...axis },
        y: { ...axis },
    },
    ...overrides,
});
