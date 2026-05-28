<?php

namespace ColorlibHQ\AdminLte\Console;

use Illuminate\Console\Command;

class ScaffoldCommand extends Command
{
    protected $signature = 'adminlte:scaffold
                            {section? : The section to scaffold (mailbox, chat, kanban, calendar, projects, file-manager, profile, settings, invoice, pricing, faq)}
                            {--all : Scaffold all sections}
                            {--force : Overwrite existing files}
                            {--seed : Run seeders after publishing}';

    protected $description = 'Scaffold AdminLTE sections (mailbox, chat, kanban, etc.) with full DB backing';

    protected array $sections = [
        'mailbox' => 'Messages mailbox with inbox/read/compose',
        'chat' => 'Conversations and chat messaging',
        'kanban' => 'Kanban boards with drag-to-reorder cards',
        'calendar' => 'Event calendar with FullCalendar',
        'projects' => 'Project management CRUD',
        'file-manager' => 'File browser using Laravel Storage',
        'profile' => 'User profile page',
        'settings' => 'User settings page',
        'invoice' => 'Invoice generator',
        'pricing' => 'Pricing page',
        'faq' => 'FAQ accordion',
    ];

    public function handle(): int
    {
        $section = $this->argument('section');
        $all = $this->option('all');
        $force = $this->option('force');
        $seed = $this->option('seed');

        if ($all) {
            $this->scaffoldAll($force, $seed);

            return 0;
        }

        if ($section) {
            if (! isset($this->sections[$section])) {
                $this->error("Section '{$section}' not found.");

                return 1;
            }
            $this->scaffoldSection($section, $force, $seed);

            return 0;
        }

        $this->info('Select sections to scaffold:');
        $selected = $this->choice(
            'Which sections?',
            array_keys($this->sections),
            multiple: true
        );

        foreach ($selected as $sect) {
            $this->scaffoldSection($sect, $force, $seed);
        }

        return 0;
    }

    protected function scaffoldAll(bool $force, bool $seed): void
    {
        foreach (array_keys($this->sections) as $section) {
            $this->scaffoldSection($section, $force, seed: false);
        }

        if ($seed) {
            $this->call('db:seed');
        }

        $this->info('✓ All sections scaffolded.');
    }

    protected function scaffoldSection(string $section, bool $force, bool $seed = false): void
    {
        $this->info("Scaffolding '{$section}'...");

        // Publish stubs based on section
        match ($section) {
            'mailbox' => $this->scaffoldMailbox($force, $seed),
            'chat' => $this->scaffoldChat($force, $seed),
            'kanban' => $this->scaffoldKanban($force, $seed),
            'calendar' => $this->scaffoldCalendar($force, $seed),
            'projects' => $this->scaffoldProjects($force, $seed),
            'file-manager' => $this->scaffoldFileManager($force, $seed),
            'profile' => $this->scaffoldProfile($force, $seed),
            'settings' => $this->scaffoldSettings($force, $seed),
            'invoice' => $this->scaffoldInvoice($force, $seed),
            'pricing' => $this->scaffoldPricing($force, $seed),
            'faq' => $this->scaffoldFaq($force, $seed),
        };

        $this->info("✓ '{$section}' scaffolded.");
    }

    protected function scaffoldMailbox(bool $force, bool $seed): void
    {
        // Publish migration
        $this->publishFile(
            'stubs/migrations/create_adminlte_messages_table.php.stub',
            database_path('migrations/'.date('Y_m_d_His').'_create_adminlte_messages_table.php'),
            $force
        );

        // Publish model
        $this->publishFile(
            'stubs/models/Message.php.stub',
            app_path('Models/Message.php'),
            $force
        );

        // Publish controller
        $this->publishFile(
            'stubs/controllers/MailboxController.php.stub',
            app_path('Http/Controllers/AdminLte/MailboxController.php'),
            $force
        );

        // Publish views
        $this->publishDirectory(
            'stubs/views/mailbox',
            resource_path('views/adminlte/mailbox'),
            $force
        );

        // Publish seeder
        $this->publishFile(
            'stubs/seeders/AdminLteMailboxSeeder.php.stub',
            database_path('seeders/AdminLteMailboxSeeder.php'),
            $force
        );

        if ($seed) {
            $this->call('db:seed', ['--class' => 'AdminLteMailboxSeeder']);
        }
    }

    protected function scaffoldChat(bool $force, bool $seed): void
    {
        $this->comment('Chat scaffolding stub — implement similar to mailbox');
    }

    protected function scaffoldKanban(bool $force, bool $seed): void
    {
        $this->comment('Kanban scaffolding stub — implement similar to mailbox');
    }

    protected function scaffoldCalendar(bool $force, bool $seed): void
    {
        $this->comment('Calendar scaffolding stub — implement similar to mailbox');
    }

    protected function scaffoldProjects(bool $force, bool $seed): void
    {
        $this->comment('Projects scaffolding stub — implement similar to mailbox');
    }

    protected function scaffoldFileManager(bool $force, bool $seed): void
    {
        $this->comment('File manager scaffolding stub — no migration needed');
    }

    protected function scaffoldProfile(bool $force, bool $seed): void
    {
        $this->publishDirectory(
            'stubs/views/profile',
            resource_path('views/adminlte/profile'),
            $force
        );
    }

    protected function scaffoldSettings(bool $force, bool $seed): void
    {
        $this->publishDirectory(
            'stubs/views/settings',
            resource_path('views/adminlte/settings'),
            $force
        );
    }

    protected function scaffoldInvoice(bool $force, bool $seed): void
    {
        $this->publishDirectory(
            'stubs/views/invoice',
            resource_path('views/adminlte/invoice'),
            $force
        );
    }

    protected function scaffoldPricing(bool $force, bool $seed): void
    {
        $this->publishDirectory(
            'stubs/views/pricing',
            resource_path('views/adminlte/pricing'),
            $force
        );
    }

    protected function scaffoldFaq(bool $force, bool $seed): void
    {
        $this->publishDirectory(
            'stubs/views/faq',
            resource_path('views/adminlte/faq'),
            $force
        );
    }

    protected function publishFile(string $stub, string $path, bool $force): void
    {
        if (file_exists($path) && ! $force) {
            $this->warn("  File exists: {$path}");

            return;
        }

        $content = file_get_contents(__DIR__.'/../../resources/'.$stub);
        $dir = dirname($path);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, recursive: true);
        }
        file_put_contents($path, $content);
        $this->line("  <info>✓</info> {$path}");
    }

    protected function publishDirectory(string $stub, string $path, bool $force): void
    {
        $stubPath = __DIR__.'/../../resources/'.$stub;
        if (! is_dir($stubPath)) {
            return;
        }

        if (! is_dir($path)) {
            mkdir($path, 0755, recursive: true);
        }

        foreach (glob($stubPath.'/*') as $file) {
            $dest = $path.'/'.basename($file);
            if (file_exists($dest) && ! $force) {
                continue;
            }
            copy($file, $dest);
            $this->line("  <info>✓</info> {$dest}");
        }
    }
}
