<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
// write logs directly to storage_path to avoid missing filesystem disk config

class NormalizeStudentEmails extends Command
{
    protected $signature = 'students:normalize-emails {--dry-run}';
    protected $description = 'Normalize existing student emails to include class marker (e.g. .12) based on their active class.';

    public function handle()
    {
        $dry = $this->option('dry-run');
        $this->info('Starting normalization of student emails'.($dry ? ' (dry-run)' : ''));

        $logEntries = [];

        $students = User::where('role','siswa')->get();
        foreach ($students as $s) {
            $current = $s->email;
            $local = strtolower((string) strtok($current, '@'));
            $domain = strtolower((string) substr($current, strpos($current, '@') + 1));

            $detected = User::detectTingkatFromIdentifier($local) ?? User::detectTingkatFromIdentifier((string)$s->nis);
            $actualKelas = $s->kelasAktif()?->kelas?->tingkat;

            if (!$actualKelas) {
                $logEntries[] = "SKIP {$s->id} ({$s->name}): no active class";
                continue;
            }

            // If already has marker and matches actual class, skip
            if ($detected && $detected == $actualKelas) {
                $logEntries[] = "OK {$s->id} ({$s->name}): already marked ({$current})";
                continue;
            }

            // Only alter if no marker detected
            if ($detected) {
                $logEntries[] = "MISMATCH {$s->id} ({$s->name}): detected {$detected} but actual {$actualKelas} — SKIP";
                continue;
            }

            // Build candidate new local part
            $base = $local;
            $candidate = "{$base}.{$actualKelas}";
            $newEmail = "{$candidate}@{$domain}";
            $suffix = 0;
            while (User::where('email',$newEmail)->exists()) {
                $suffix++;
                $newEmail = "{$candidate}-{$suffix}@{$domain}";
            }

            $logEntries[] = ($dry ? 'DRY ' : 'UPDATE') . " {$s->id} ({$s->name}): {$current} => {$newEmail}";

            if (!$dry) {
                $s->email = $newEmail;
                $s->save();
            }
        }

        $log = implode("\n", $logEntries) . "\n";
        $basename = 'normalize_emails_'.date('Ymd_His').'.log';
        $dir = storage_path('app/logs');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        file_put_contents($dir.DIRECTORY_SEPARATOR.$basename, $log);

        $this->info('Done. Log written to storage/app/logs/'.$basename);
        return 0;
    }
}
