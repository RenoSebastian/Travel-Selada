<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Entities\MBus; // Pastikan untuk menggunakan namespace yang sesuai

class MBusCommand extends Command
{
    protected $signature = 'mbus:manage {action} {id?} {--tipe_bus=} {--kapasitas_bus=}';
    protected $description = 'Manage MBus data: edit or delete';

    public function handle()
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'edit':
                return $this->editMBus();
            case 'delete':
                return $this->deleteMBus();
            default:
                $this->error('Action not recognized. Use "edit" or "delete".');
                break;
        }
    }

    protected function editMBus()
    {
        $id = $this->argument('id');
        $tipeBus = $this->option('tipe_bus');
        $kapasitasBus = $this->option('kapasitas_bus');

        // Mencari data m_bus berdasarkan ID
        $mbus = MBus::find($id);

        if (!$mbus) {
            $this->error('Data m_bus tidak ditemukan dengan ID: ' . $id);
            return;
        }

        // Update data m_bus
        if ($tipeBus) {
            $mbus->tipe_bus = $tipeBus;
        }
        if ($kapasitasBus) {
            $mbus->kapasitas_bus = $kapasitasBus;
        }
        $mbus->save();

        $this->info('Data m_bus dengan ID ' . $id . ' berhasil diperbarui.');
    }

    protected function deleteMBus()
    {
        $id = $this->argument('id');

        // Mencari data m_bus berdasarkan ID
        $mbus = MBus::find($id);

        if (!$mbus) {
            $this->error('Data m_bus tidak ditemukan dengan ID: ' . $id);
            return;
        }

        // Menghapus data m_bus
        $mbus->delete();
        $this->info('Data m_bus dengan ID ' . $id . ' berhasil dihapus.');
    }
}
