import './bootstrap';
import Alpine from 'alpinejs';
import { BrowserQRCodeReader } from '@zxing/browser';

window.Alpine = Alpine;

// =========================================================
// Sound Effects (Web Audio API — no external files needed)
// =========================================================
const AudioCtx = window.AudioContext || window.webkitAudioContext;
let audioCtx = null;

function getAudioCtx() {
    if (!audioCtx) audioCtx = new AudioCtx();
    return audioCtx;
}

function playTick(pitch = 800, duration = 0.04) {
    try {
        const ctx = getAudioCtx();
        const osc = ctx.createOscillator();
        const gain = ctx.createGain();
        osc.type = 'sine';
        osc.frequency.value = pitch;
        gain.gain.setValueAtTime(0.15, ctx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + duration);
        osc.connect(gain).connect(ctx.destination);
        osc.start(); osc.stop(ctx.currentTime + duration);
    } catch(e) { /* audio not available */ }
}

function playReveal(type = 'win') {
    try {
        const ctx = getAudioCtx();
        const notes = type === 'win'
            ? [523, 659, 784, 1047]
            : type === 'legendary'
            ? [523, 784, 1047, 1319, 1568]
            : [400, 350, 300, 250];

        notes.forEach((freq, i) => {
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.type = type === 'legendary' ? 'triangle' : (type === 'win' ? 'sine' : 'sawtooth');
            osc.frequency.value = freq;
            const t = ctx.currentTime + i * 0.12;
            gain.gain.setValueAtTime(0.2, t);
            gain.gain.exponentialRampToValueAtTime(0.001, t + 0.3);
            osc.connect(gain).connect(ctx.destination);
            osc.start(t); osc.stop(t + 0.3);
        });

        if (type === 'legendary') {
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.type = 'sine';
            osc.frequency.value = 80;
            gain.gain.setValueAtTime(0.3, ctx.currentTime + 0.5);
            gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 1.2);
            osc.connect(gain).connect(ctx.destination);
            osc.start(ctx.currentTime + 0.5); osc.stop(ctx.currentTime + 1.2);
        }
    } catch(e) { /* audio not available */ }
}

function playDrumroll() {
    try {
        const ctx = getAudioCtx();
        for (let i = 0; i < 20; i++) {
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.type = 'triangle';
            osc.frequency.value = 200 + Math.random() * 100;
            const t = ctx.currentTime + i * 0.05;
            gain.gain.setValueAtTime(0.08 + (i * 0.005), t);
            gain.gain.exponentialRampToValueAtTime(0.001, t + 0.06);
            osc.connect(gain).connect(ctx.destination);
            osc.start(t); osc.stop(t + 0.06);
        }
    } catch(e) { /* audio not available */ }
}

// =========================================================
// Alpine.js Game Components
// =========================================================

/**
 * Page transition on load
 */
Alpine.data('pageTransition', () => ({
    show: false,
    enter() {
        setTimeout(() => this.show = true, 50);
    }
}));

/**
 * Live score polling for the header
 * Polls the team's score every 5 seconds
 */
Alpine.data('liveScore', (teamId, initialScore = 0) => ({
    score: initialScore,
    delta: 0,
    _interval: null,

    init() {
        if (!teamId) return;
        this._interval = setInterval(() => this.fetchScore(), 5000);
    },

    async fetchScore() {
        try {
            const res = await fetch(`/api/team/${teamId}/score`);
            if (!res.ok) return;
            const data = await res.json();
            const newScore = data.score;
            if (newScore !== this.score) {
                this.delta = newScore - this.score;
                this.score = newScore;
                setTimeout(() => this.delta = 0, 2000);
            }
        } catch (e) { /* silent */ }
    },

    destroy() {
        if (this._interval) clearInterval(this._interval);
    }
}));

/**
 * Live leaderboard with polling and rank change detection
 */
Alpine.data('liveLeaderboard', (gameId, initialTeams) => ({
    teams: [],
    previousRanks: {},
    _interval: null,

    init() {
        // Initialize from server-rendered data
        this.teams = (initialTeams || []).map((t, i) => ({
            ...t,
            rankDelta: 0,
            rankChanged: false,
        }));
        this.teams.forEach((t, i) => { this.previousRanks[t.id] = i + 1; });
    },

    startPolling() {
        this._interval = setInterval(() => this.fetchScores(), 3000);
    },

    async fetchScores() {
        try {
            const res = await fetch(`/api/game/${gameId}/scores`);
            if (!res.ok) return;
            const newTeams = await res.json();

            const newRanks = {};
            newTeams.forEach((t, i) => { newRanks[t.id] = i + 1; });

            this.teams = newTeams.map((t, i) => {
                const prev = this.previousRanks[t.id];
                const delta = prev ? prev - newRanks[t.id] : 0;
                return {
                    ...t,
                    rankDelta: delta,
                    rankChanged: delta !== 0,
                };
            });

            this.previousRanks = newRanks;

            // Clear rank change indicators after animation
            setTimeout(() => {
                this.teams = this.teams.map(t => ({ ...t, rankDelta: 0, rankChanged: false }));
            }, 2000);
        } catch (e) { /* silent */ }
    },

    destroy() {
        if (this._interval) clearInterval(this._interval);
    }
}));

/**
 * Score count-up animation
 */
Alpine.data('scoreCounter', (from, to) => ({
    displayValue: from,
    init() {
        const duration = 800;
        const steps = 30;
        const diff = to - from;
        const stepVal = diff / steps;
        let current = 0;

        const interval = setInterval(() => {
            current++;
            this.displayValue = Math.round(from + stepVal * current);
            if (current >= steps) {
                this.displayValue = to;
                clearInterval(interval);
            }
        }, duration / steps);
    }
}));

/**
 * Encounter reveal animation state machine
 */
Alpine.data('encounterReveal', (rarity = 'common') => ({
    phase: 'loading',
    rarity,

    init() {
        setTimeout(() => this.phase = 'suspense', 300);
        setTimeout(() => this.phase = 'reveal', 1800);
        setTimeout(() => this.phase = 'result', 3200);
    },

    get animClass() {
        const map = {
            common:    'animate-[common-reveal_0.5s_ease_forwards]',
            rare:      'animate-[rare-reveal_0.6s_ease_forwards]',
            epic:      'animate-[epic-reveal_0.8s_cubic-bezier(0.34,1.56,0.64,1)_forwards]',
            cursed:    'animate-[cursed-reveal_0.6s_ease_forwards]',
            legendary: 'animate-[legendary-reveal_1s_ease_forwards]',
        };
        return map[this.rarity] || map.common;
    },
}));

/**
 * Confetti burst
 */
Alpine.data('confetti', () => ({
    particles: [],

    triggerConfetti(count = 30) {
        this.particles = Array.from({ length: count }, (_, i) => ({
            id: i,
            emoji: ['🎉','⭐','✨','💫','🌟'][Math.floor(Math.random() * 5)],
            left: Math.random() * 100,
            delay: Math.random() * 0.5,
        }));
        setTimeout(() => this.particles = [], 2500);
    }
}));

/**
 * Bomb explosion effect
 */
Alpine.data('bombEffect', () => ({
    exploding: false,

    explode() {
        this.exploding = true;
        if (navigator.vibrate) navigator.vibrate([200, 100, 200]);
        setTimeout(() => this.exploding = false, 1200);
    }
}));

/**
 * CSGO-style case opening reel animation
 * Generates a horizontal strip of random items, spins it with deceleration,
 * and lands on the actual result with sound effects.
 */
Alpine.data('caseOpening', (resultPoints, resultRarity = 'common') => ({
    phase: 'idle',       // idle → spinning → slowdown → reveal → done
    items: [],
    winIndex: 0,
    offset: 0,
    showResult: false,
    resultPoints,
    resultRarity,
    _anim: null,

    init() {
        const pool = [
            { emoji: '❓', label: 'Vraag', points: '+2', rarity: 'rare' },
            { emoji: '❓', label: 'Vraag', points: '+2', rarity: 'rare' },
            { emoji: '💣', label: 'Bom!', points: '-3', rarity: 'cursed' },
            { emoji: '💣', label: 'Bom!', points: '-2', rarity: 'cursed' },
            { emoji: '⭐', label: 'Bonus', points: '+3', rarity: 'epic' },
            { emoji: '✨', label: 'Klein', points: '+1', rarity: 'common' },
            { emoji: '✨', label: 'Klein', points: '+1', rarity: 'common' },
            { emoji: '💀', label: 'Verlies', points: '-1', rarity: 'cursed' },
            { emoji: '🏆', label: 'Jackpot!', points: '+5', rarity: 'legendary' },
            { emoji: '🎯', label: 'Opdracht', points: '+2', rarity: 'rare' },
            { emoji: '🛡️', label: 'Schild', points: '0', rarity: 'common' },
            { emoji: '🔥', label: 'Fire!', points: '+4', rarity: 'epic' },
            { emoji: '💎', label: 'Diamant', points: '+5', rarity: 'legendary' },
            { emoji: '👻', label: 'Spook', points: '-2', rarity: 'cursed' },
            { emoji: '🎪', label: 'Circus', points: '+1', rarity: 'common' },
            { emoji: '🌈', label: 'Regenboog', points: '+3', rarity: 'epic' },
        ];

        const totalItems = 55;
        this.winIndex = 48;

        this.items = [];
        for (let i = 0; i < totalItems; i++) {
            if (i === this.winIndex) {
                const icon = resultPoints >= 4 ? '💎' : resultPoints >= 2 ? '⭐' : resultPoints > 0 ? '✨' : resultPoints === 0 ? '🛡️' : resultPoints >= -1 ? '💀' : '💣';
                const label = resultPoints >= 4 ? 'Jackpot!' : resultPoints >= 2 ? 'Bonus!' : resultPoints > 0 ? 'Klein' : resultPoints === 0 ? 'Niets' : 'Verlies';
                this.items.push({
                    emoji: icon,
                    label: label,
                    points: (resultPoints > 0 ? '+' : '') + resultPoints,
                    rarity: resultRarity,
                    isWinner: true,
                });
            } else {
                this.items.push({ ...pool[Math.floor(Math.random() * pool.length)], isWinner: false });
            }
        }
    },

    spin() {
        this.phase = 'spinning';
        playDrumroll();

        const itemWidth = 100; // px per reel item
        const targetOffset = this.winIndex * itemWidth;
        const jitter = (Math.random() * 40) - 20;
        const finalOffset = targetOffset + jitter;

        const duration = 5500;
        const startTime = performance.now();
        let lastTickItem = -1;

        const animate = (now) => {
            const elapsed = now - startTime;
            const progress = Math.min(elapsed / duration, 1);

            // Cubic ease-out for CSGO slowdown feel
            const eased = 1 - Math.pow(1 - progress, 3);
            this.offset = finalOffset * eased;

            // Tick sound as each new item passes center
            const currentItem = Math.floor(this.offset / itemWidth);
            if (currentItem !== lastTickItem && currentItem >= 0) {
                lastTickItem = currentItem;
                const pitch = 600 + (progress * 600) + (Math.random() * 100);
                playTick(pitch, 0.03 + progress * 0.03);
            }

            if (progress >= 0.8 && this.phase === 'spinning') {
                this.phase = 'slowdown';
            }

            if (progress < 1) {
                this._anim = requestAnimationFrame(animate);
            } else {
                this.phase = 'reveal';
                const soundType = resultPoints >= 4 ? 'legendary' : resultPoints > 0 ? 'win' : 'loss';
                playReveal(soundType);
                if (navigator.vibrate) {
                    navigator.vibrate(resultPoints > 0 ? [100, 50, 100, 50, 200] : [300, 100, 300]);
                }
                setTimeout(() => {
                    this.showResult = true;
                    this.phase = 'done';
                }, 1200);
            }
        };

        this._anim = requestAnimationFrame(animate);
    },

    destroy() {
        if (this._anim) cancelAnimationFrame(this._anim);
    }
}));

/**
 * Home QR scanner
 * Uses device camera and redirects to /qr/{slug} when a valid game code is detected.
 */
Alpine.data('homeScanner', () => ({
    ready: false,
    scanning: false,
    status: 'Klaar om te scannen',
    error: '',
    redirecting: false,
    reader: null,

    init() {
        setTimeout(() => {
            this.ready = true;
            this.startScanner();
        }, 100);
    },

    async startScanner() {
        this.error = '';
        if (this.scanning || this.redirecting) return;

        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            this.error = 'Je browser ondersteunt geen camera-scannen.';
            return;
        }

        try {
            this.reader = this.reader || new BrowserQRCodeReader();
            this.scanning = true;
            this.status = 'Camera starten...';

            this.reader.decodeFromConstraints(
                {
                    audio: false,
                    video: {
                        facingMode: { ideal: 'environment' }
                    }
                },
                this.$refs.scannerVideo,
                (result) => {
                    if (!result || this.redirecting) return;

                    const target = this.resolveQrTarget(result.getText());
                    if (!target) {
                        this.status = 'QR gelezen, maar code is ongeldig';
                        return;
                    }

                    this.redirecting = true;
                    this.status = 'QR-code gevonden, openen...';
                    this.stopScanner();
                    window.location.assign(target);
                }
            );

            this.status = 'Richt je camera op een QR-code';
        } catch (e) {
            this.scanning = false;
            this.error = e?.message || 'Camera kon niet gestart worden.';
        }
    },

    stopScanner() {
        if (this.reader) {
            this.reader.reset();
        }
        this.scanning = false;
        if (!this.redirecting) {
            this.status = 'Scanner gestopt';
        }
    },

    resolveQrTarget(rawValue) {
        const value = (rawValue || '').trim();
        if (!value) return null;

        if (/^[A-Za-z0-9_-]+$/.test(value)) {
            return `/qr/${encodeURIComponent(value)}`;
        }

        try {
            const parsed = new URL(value, window.location.origin);
            const marker = '/qr/';
            const pos = parsed.pathname.indexOf(marker);
            if (pos === -1) return null;

            const slug = parsed.pathname.substring(pos + marker.length).split('/')[0];
            if (!slug) return null;

            return `/qr/${encodeURIComponent(decodeURIComponent(slug))}`;
        } catch {
            return null;
        }
    },

    destroy() {
        this.stopScanner();
    }
}));

Alpine.start();

// =========================================================
// Laravel Echo + Pusher for Reverb (optional)
// Only initialize if config is present
// =========================================================
if (import.meta.env.VITE_REVERB_APP_KEY) {
    import('laravel-echo').then(({ default: Echo }) => {
        import('pusher-js').then(({ default: Pusher }) => {
            window.Pusher = Pusher;
            window.Echo = new Echo({
                broadcaster: 'reverb',
                key: import.meta.env.VITE_REVERB_APP_KEY,
                wsHost: import.meta.env.VITE_REVERB_HOST,
                wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
                wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
                forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
                enabledTransports: ['ws', 'wss'],
            });
        });
    });
}

