<?php
// Local demo books. They live in this file and img-books/, never in the database.
// Reservations for them are kept in demo_data/holds.json, because book_holds has a
// foreign key to librat and cannot point at a book that is not in that table.
//
// Copies available = total_books - that book's pending holds. So a reservation takes
// one copy and a return gives it back, as with database books.
//
// To reset the demo, delete demo_data/holds.json.

const DEMO_ID_START = 900000; // Book and hold ids above this are demo records.
const DEMO_HOLDS_FILE = __DIR__ . '/demo_data/holds.json';
const DEMO_HOME_BOOK_IDS = [900013, 900024, 900031, 900035]; // Shown on the home pages.

function demo_catalog(): array
{
    // id => [cover file in img-books/, title, author, category, dummy stock, description]
    // Categories use the stored values from books.php: Fantazi is shown as Thriller,
    // Dramë as Romancë, Aventurë as Poezia and Mister as Klasikët.
    $dukagjini = 'Shtëpia botuese DUKAGJINI';

    return [
        900001 => ['4.-Edukate-Fizike-4.png', 'Edukatë Fizike, Sportet dhe Shëndeti 4', $dukagjini, 'Klasa 1-5', 4, 'Tekst mësimor për klasën e katërt të arsimit fillor.'],
        900002 => ['4.-Gjuha-Shqipe-4a.png', 'Gjuha Shqipe 4a', $dukagjini, 'Klasa 1-5', 6, 'Tekst mësimor për klasën e katërt të arsimit fillor.'],
        900003 => ['5.Edukate-Figurative-5.png', 'Edukatë Figurative 5', $dukagjini, 'Klasa 1-5', 3, 'Tekst mësimor për klasën e pestë të arsimit fillor.'],
        900004 => ['5.-Shkathtesi-per-jete-5-Baza.png', 'Shkathtësi për Jetë 5', $dukagjini, 'Klasa 1-5', 5, 'Tekst mësimor për klasën e pestë të arsimit fillor.'],

        900005 => ['6.-Matematika-6-Baza.png', 'Matematika 6', $dukagjini, 'Klasa 6-9', 7, 'Tekst mësimor për klasën e gjashtë të arsimit të mesëm të ulët.'],
        900006 => ['bio-6.png', 'Biologjia 6', $dukagjini, 'Klasa 6-9', 5, 'Tekst mësimor për klasën e gjashtë të arsimit të mesëm të ulët.'],
        900007 => ['fizika-baza 6.png', 'Fizika 6', $dukagjini, 'Klasa 6-9', 4, 'Tekst mësimor për klasën e gjashtë të arsimit të mesëm të ulët.'],
        900008 => ['gjeo-baza-6.png', 'Gjeografia 6', $dukagjini, 'Klasa 6-9', 4, 'Tekst mësimor për klasën e gjashtë të arsimit të mesëm të ulët.'],
        900009 => ['BIOLOGJIA-KL-7.png', 'Biologjia 7', $dukagjini, 'Klasa 6-9', 6, 'Tekst mësimor për klasën e shtatë të arsimit të mesëm të ulët.'],
        900010 => ['BIO-7.png', 'Biologjia 7 - Fletore Pune', $dukagjini, 'Klasa 6-9', 8, 'Fletore pune për klasën e shtatë të arsimit të mesëm të ulët.'],
        900011 => ['edukat-qytetare-7-baza.png', 'Edukatë Qytetare 7', $dukagjini, 'Klasa 6-9', 3, 'Tekst mësimor për klasën e shtatë të arsimit të mesëm të ulët.'],
        900012 => ['8.-Kimia-8-Baza.png', 'Kimia 8', $dukagjini, 'Klasa 6-9', 5, 'Tekst mësimor për klasën e tetë të arsimit të mesëm të ulët.'],
        900014 => ['8.-Teknologji-me-Tik-8-Baza.png', 'Teknologji me TIK 8', $dukagjini, 'Klasa 6-9', 4, 'Tekst mësimor për klasën e tetë të arsimit të mesëm të ulët.'],
        900015 => ['9.-Gjeografia-9-Baze.png', 'Gjeografia 9', $dukagjini, 'Klasa 6-9', 5, 'Tekst mësimor për klasën e nëntë të arsimit të mesëm të ulët.'],
        900016 => ['9.-Kimia-9-Baza.png', 'Kimia 9', $dukagjini, 'Klasa 6-9', 3, 'Tekst mësimor për klasën e nëntë të arsimit të mesëm të ulët.'],
        900017 => ['9.-Tik-9-Baza.png', 'Teknologji me TIK 9', $dukagjini, 'Klasa 6-9', 6, 'Tekst mësimor për klasën e nëntë të arsimit të mesëm të ulët.'],

        900018 => ['10.-Gjuhe-Shqipe-dhe-Letersi-10-Fletore-Pune.png', 'Gjuhë Shqipe dhe Letërsi 10 - Fletore Pune', $dukagjini, 'Klasa 10-12', 8, 'Fletore pune për klasën e dhjetë të arsimit të mesëm të lartë.'],
        900013 => ['10.-Matematika-10-Natyrore.png', 'Matematika 10 - Natyrore', $dukagjini, 'Klasa 10-12', 6, 'Tekst mësimor për klasën e dhjetë, gjimnazi i shkencave natyrore.'],
        900019 => ['10.-Tik-10.png', 'TIK 10', $dukagjini, 'Klasa 10-12', 4, 'Tekst mësimor për klasën e dhjetë të arsimit të mesëm të lartë.'],
        900020 => ['11.-Matematika-11-Baza.png', 'Matematika 11', $dukagjini, 'Klasa 10-12', 5, 'Tekst mësimor për klasën e njëmbëdhjetë, gjimnazi i shkencave natyrore.'],
        900021 => ['11.-Matematika-11-Fletore-Pune.png', 'Matematika 11 - Fletore Pune', $dukagjini, 'Klasa 10-12', 7, 'Fletore pune për klasën e njëmbëdhjetë, gjimnazi i shkencave natyrore.'],
        900022 => ['12.-Matematika-12-Shoqerore.png', 'Matematika 12 - Shoqërore', $dukagjini, 'Klasa 10-12', 5, 'Tekst mësimor për klasën e dymbëdhjetë, gjimnazi i shkencave shoqërore-gjuhësore.'],
        900023 => ['12.-Matematika-12-Shoqerore-Permbledhje-Detyrash.png', 'Matematika 12 - Përmbledhje Detyrash', $dukagjini, 'Klasa 10-12', 4, 'Përmbledhje detyrash për klasën e dymbëdhjetë, gjimnazi i shkencave shoqërore-gjuhësore.'],

        900024 => ['Good Girl Bad Blood(Thriller).jpg', 'Good Girl, Bad Blood', 'Holly Jackson', 'Fantazi', 4, 'Thriller, vazhdim i romanit A Good Girl\'s Guide to Murder.'],
        900025 => ['One Of Us Is Next(Thriller).jpg', 'One of Us Is Next', 'Karen M. McManus', 'Fantazi', 3, 'Thriller, vazhdim i romanit One of Us Is Lying.'],
        900026 => ['Woman Down(Thriller).jpg', 'Woman Down', 'Colleen Hoover', 'Fantazi', 5, 'Roman thriller.'],
        900027 => ['Ajlina(Thriller).jpg', 'Ajlina', 'Ayşe Kulin', 'Fantazi', 2, 'Roman nga një prej autoreve më të lexuara të letërsisë turke.'],

        900028 => ['It Ends With Us(Romance).jpeg', 'It Ends With Us', 'Colleen Hoover', 'Dramë', 6, 'Roman dashurie.'],
        900029 => ['Our Perfect Storm(Romance).jpg', 'Our Perfect Storm', 'Carley Fortune', 'Dramë', 3, 'Roman dashurie.'],
        900030 => ['Daisy Chain Flower Shop(Romace).jpg', 'The Daisy Chain Flower Shop', 'Laurie Gilmore', 'Dramë', 4, 'Roman dashurie.'],
        900032 => ['Heart The Lover(Romance).jpg', 'Heart the Lover', 'Lily King', 'Dramë', 2, 'Roman dashurie.'],
        900033 => ['Insatiable(Romance).jpg', 'Insatiable', 'Leigh Rivers', 'Dramë', 3, 'Libri i parë i trilogjisë The Edge of Darkness.'],

        900034 => ['I Have More Souls Than One(Poezi).jpg', 'I Have More Souls Than One', 'Fernando Pessoa', 'Aventurë', 2, 'Përzgjedhje poezish, seria Penguin Modern.'],
        900035 => ['The Odyssey(Poezi).jpg', 'The Odyssey', 'Homer', 'Aventurë', 4, 'Poema epike e Homerit, seria Penguin Classics.'],
        900036 => ['White Book(Poezi).jpg', 'The White Book', 'Han Kang', 'Aventurë', 3, 'Vepër e fitueses së Çmimit Nobel në Letërsi 2024.'],
        900037 => ['Leter Ne Nentor(Poezi).png', 'Letër në nëntor', 'Elvana Zaimi-Tufa', 'Aventurë', 3, 'Antologji e poezisë botërore.'],

        900031 => ['Crime And Punishment(Classic).jpg', 'Crime and Punishment', 'Fyodor Dostoevsky', 'Mister', 5, 'Roman klasik, seria Wordsworth Classics.'],
        900038 => ['The Idiot(Classic).jpg', 'The Idiot', 'Fyodor Dostoevsky', 'Mister', 3, 'Roman klasik, seria Wordsworth Classics.'],
        900039 => ['The Count Of Monte Cristo(Classic).jpg', 'The Count of Monte Cristo', 'Alexandre Dumas', 'Mister', 4, 'Roman klasik, seria Wordsworth Classics.'],
    ];
}

function demo_is_id(int $id): bool
{
    return $id > DEMO_ID_START;
}

// All demo books, shaped like librat rows so book_card.php and details.php can use them.
function demo_books(): array
{
    $pending = [];
    foreach (demo_read_holds() as $hold) {
        if ($hold['return_status'] === 'pending') {
            $pending[$hold['book_id']] = ($pending[$hold['book_id']] ?? 0) + 1;
        }
    }

    $books = [];
    foreach (demo_catalog() as $id => [$file, $title, $author, $category, $stock, $description]) {
        $books[$id] = [
            'id' => $id,
            'title' => $title,
            'author' => $author,
            'description' => $description,
            'category' => $category,
            'cover' => 'img-books/' . rawurlencode($file),
            'total_books' => $stock,
            'available_books' => max(0, $stock - ($pending[$id] ?? 0)),
            'is_held' => 0,
        ];
    }
    return $books;
}

function demo_find_book(int $id): ?array
{
    return demo_books()[$id] ?? null;
}

function demo_books_in_category(string $category): array
{
    $books = demo_books();
    if ($category === '') {
        return array_values($books);
    }
    return array_values(array_filter($books, fn($book) => $book['category'] === $category));
}

function demo_home_books(): array
{
    $books = demo_books();
    return array_map(fn($id) => $books[$id], DEMO_HOME_BOOK_IDS);
}

// Matches like the database search: any case, and ë/ç count as e/c.
function demo_search_books(string $term): array
{
    $fold = fn($text) => strtr(mb_strtolower($text, 'UTF-8'), ['ë' => 'e', 'ç' => 'c']);
    $term = $fold($term);

    return array_values(array_filter(demo_books(), function ($book) use ($fold, $term) {
        return str_contains($fold($book['title']), $term) || str_contains($fold($book['author']), $term);
    }));
}

// Where a card or details page loads a cover from, for demo and database books alike.
function book_cover_url(array $book): string
{
    return $book['cover'] ?? 'view.php?id=' . (int) $book['id'];
}

function demo_read_holds(): array
{
    $handle = @fopen(DEMO_HOLDS_FILE, 'r');
    if (!$handle) {
        return []; // No file yet means no reservations yet.
    }
    flock($handle, LOCK_SH);
    $holds = json_decode(stream_get_contents($handle), true);
    flock($handle, LOCK_UN);
    fclose($handle);
    return is_array($holds) ? $holds : [];
}

// Runs $change on the holds under a file lock, so two requests can't take the same copy.
// $change returns true if it changed anything; only then is the file written.
function demo_change_holds(callable $change): bool
{
    $handle = @fopen(DEMO_HOLDS_FILE, 'c+');
    if (!$handle) {
        error_log('Demo holds file could not be opened: ' . DEMO_HOLDS_FILE);
        return false;
    }
    flock($handle, LOCK_EX);
    $holds = json_decode(stream_get_contents($handle), true);
    $holds = is_array($holds) ? $holds : [];

    $changed = $change($holds);
    if ($changed) {
        rewind($handle);
        ftruncate($handle, 0);
        fwrite($handle, json_encode($holds, JSON_PRETTY_PRINT));
        fflush($handle);
    }

    flock($handle, LOCK_UN);
    fclose($handle);
    return $changed;
}

// Returns false if the date is invalid or no copy is left.
function demo_place_hold(int $user_id, int $book_id, string $pickup_date): bool
{
    $stock = demo_catalog()[$book_id][4] ?? 0;
    $date = DateTime::createFromFormat('Y-m-d', $pickup_date);
    if (!$date || $date->format('Y-m-d') !== $pickup_date) {
        return false;
    }

    return demo_change_holds(function (array &$holds) use ($user_id, $book_id, $pickup_date, $stock) {
        $pending = 0;
        $last_id = DEMO_ID_START;
        foreach ($holds as $hold) {
            $last_id = max($last_id, $hold['id']);
            if ($hold['book_id'] === $book_id && $hold['return_status'] === 'pending') {
                $pending++;
            }
        }
        if ($pending >= $stock) {
            return false;
        }

        $holds[] = [
            'id' => $last_id + 1,
            'user_id' => $user_id,
            'book_id' => $book_id,
            'hold_date' => date('Y-m-d'),
            'pickup_date' => $pickup_date,
            'return_status' => 'pending',
        ];
        return true;
    });
}

// Only a pending hold can change, so a repeated submit can't give a copy back twice.
function demo_mark_returned(int $hold_id): bool
{
    return demo_change_holds(function (array &$holds) use ($hold_id) {
        foreach ($holds as &$hold) {
            if ($hold['id'] === $hold_id && $hold['return_status'] === 'pending') {
                $hold['return_status'] = 'returned';
                return true;
            }
        }
        return false;
    });
}

// Only returned holds can be deleted, as in delete_book.php.
function demo_delete_hold(int $hold_id): bool
{
    return demo_change_holds(function (array &$holds) use ($hold_id) {
        foreach ($holds as $index => $hold) {
            if ($hold['id'] === $hold_id && $hold['return_status'] === 'returned') {
                array_splice($holds, $index, 1);
                return true;
            }
        }
        return false;
    });
}

// Demo holds shaped like the rows of the admin.php query.
function demo_admin_rows(mysqli $db): array
{
    $holds = demo_read_holds();
    if (!$holds) {
        return [];
    }

    $user_ids = implode(',', array_unique(array_map(fn($hold) => (int) $hold['user_id'], $holds)));
    $users = [];
    foreach ($db->query("SELECT id, name, mbiemri, email FROM users WHERE id IN ($user_ids)") as $user) {
        $users[$user['id']] = $user;
    }

    $catalog = demo_catalog();
    $rows = [];
    foreach ($holds as $hold) {
        $user = $users[$hold['user_id']] ?? ['name' => '-', 'mbiemri' => '', 'email' => ''];
        $rows[] = [
            'id' => $hold['id'],
            'name' => $user['name'],
            'mbiemri' => $user['mbiemri'],
            'email' => $user['email'],
            'title' => $catalog[$hold['book_id']][1] ?? '-',
            'hold_date' => $hold['hold_date'],
            'pickup_date' => $hold['pickup_date'],
            'return_status' => $hold['return_status'],
        ];
    }
    return $rows;
}
