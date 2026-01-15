<?php
//este es un comando de consola que elimina todos los archivos de la carpeta TemFile 
//ubicado en public/TempFile
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearOldUploads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maintenance:clear-old-uploads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina archivos viejos por mantenimiento';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $folderPath = public_path("TempFile"); 

        if(!File::exists($folderPath)){
            $this->error("No se encontró la carpeta". $folderPath); 
            return Command::FAILURE; 
        }
        $files = File::files($folderPath); //esto es un array de los archivos en la carpeta 

        foreach($files as $file){
            File::delete($file); 
            $this->info("Archivo eliminado:" . $file->getFileName()); 
        }
        $this->info("Limpieza completada.");
        return Command::SUCCESS; 

    }
}
