<?php
// Decorative layer for the home pages, animated by buildBookJourney() in motion.js.
// It stays hidden unless that function runs, and it is ignored by clicks and screen readers.
$journeyBooks = [
    ['cover' => '#14305c', 'band' => '#f2cf85'],
    ['cover' => '#c8952e', 'band' => '#14305c'],
    ['cover' => '#a8322b', 'band' => '#f2cf85'],
];
?>
<div class="book-journey" id="bookJourney" aria-hidden="true">
    <svg class="journey-trail" preserveAspectRatio="none" focusable="false"><path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path></svg>

    <svg class="journey-shelf" viewBox="0 0 140 96" focusable="false">
        <rect x="4" y="86" width="132" height="6" rx="2" fill="#7a5a22"></rect>
        <rect x="12" y="92" width="6" height="4" fill="#5c431a"></rect>
        <rect x="122" y="92" width="6" height="4" fill="#5c431a"></rect>
    </svg>

    <?php foreach ($journeyBooks as $journeyBook): ?>
        <div class="journey-book">
            <svg class="journey-book-inner" viewBox="0 0 52 68" focusable="false">
                <rect x="6" y="3" width="44" height="63" rx="2" fill="#fbf8f1" stroke="#d9d2c0"></rect>
                <rect x="2" y="1" width="44" height="63" rx="3" fill="<?php echo $journeyBook['cover']; ?>"></rect>
                <rect x="2" y="1" width="7" height="63" rx="3" fill="#000" opacity="0.18"></rect>
                <rect x="15" y="14" width="24" height="3" rx="1.5" fill="<?php echo $journeyBook['band']; ?>"></rect>
                <rect x="15" y="21" width="16" height="3" rx="1.5" fill="<?php echo $journeyBook['band']; ?>" opacity="0.7"></rect>
                <rect x="15" y="50" width="24" height="2" rx="1" fill="<?php echo $journeyBook['band']; ?>" opacity="0.7"></rect>
            </svg>
        </div>
    <?php endforeach; ?>
</div>
