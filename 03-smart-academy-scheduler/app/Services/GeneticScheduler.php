<?php 
namespace App\Services;

use Illuminate\Support\Facades\DB; 
use App\Models\RuangKelas; 
use App\Models\ConstraintsRuang; 
use PDO; 
use PDOException; 
use App\Models\ConstraintsDosen; 
use App\Models\Kelas; 

class GeneticScheduler { 
    protected $pdo; 
    private $db; 
    
    private $crossoverRate = 0.8; 
    private $mutationRate = 0.2; 
    private $elitismCount = 40; 
    
    // Hard constraints - MUST be satisfied
    private $HARD_ROOM_CONFLICT_PENALTY = 1000; 
    private $HARD_LECTURER_CONFLICT_PENALTY = 1000; 
    private $HARD_GROUP_CONFLICT_PENALTY = 1000; 
    private $HARD_TIME_SLOT_OVERFLOW_PENALTY = 1000;
    
    // Soft constraints - preferred but can be violated
    private $SOFT_LAB_CONSTRAINT_PENALTY = 30; 
    private $SOFT_LECTURER_AVAILABILITY_PENALTY = 25; 
    private $SOFT_ROOM_CAPACITY_PENALTY = 20; 
    private $SOFT_ROOM_TYPE_MISMATCH_PENALTY = 15; 
    private $SOFT_CONSECUTIVE_SLOTS_PENALTY = 10; 
    private $SOFT_PERKULIAHAN_MISMATCH_PENALTY = 25;
    private $SOFT_ROOM_PREFERENCE_PENALTY = 20;

    // Constraint data cache 
    private $availableRoomsCache = []; 
    private $lecturerConstraintsCache = []; 
    private $roomTypeCache = []; 
    private $roomPerkuliahanCache = []; 
    
    // Encoding arrays 
    private $courseEncoding = []; 
    private $dayEncoding = []; 
    private $slotEncoding = []; 
    private $roomEncoding = []; 
    
    public function __construct($dbConn, $pdo) { 
        $this->db = $dbConn; 
        $this->pdo = $pdo; 
    } 
    
    public function runGeneticAlgorithm() { 
        $start = microtime(true); 
        
        // Ambil data matkul dari semua tabel prodi 
        $data = array_merge( 
            $this->fetchData('save_data_ti'), 
            $this->fetchData('save_data_pti'), 
            $this->fetchData('save_data_pte'), 
            $this->fetchData('save_data_trse') 
        ); 
        
        $rooms = RuangKelas::all()->toArray(); 
        $constraintRuangan = ConstraintsRuang::all()->toArray(); 
        $constraintDosen = ConstraintsDosen::all()->toArray(); 
        $kelasData = Kelas::all()->toArray(); 
        $days = DB::table('hari')->pluck('hari', 'id')->toArray(); 
        $slots = DB::table('jam')->pluck('jam_ke', 'id')->toArray(); 
        $timeSlots = DB::table('jam')->select('id', 'jam_ke', 'waktu_mulai', 'waktu_selesai')->get()->toArray(); 
        
        // Initialize constraint caches 
        $this->initializeConstraintCaches($constraintRuangan, $constraintDosen, $rooms); 
        
        // ========== TAHAP 1: ENCODING ========== 
        echo "=== TAHAP 1: ENCODING DATA ===" . PHP_EOL; 
        $this->performEncoding($data, $days, $slots, $rooms); 
        
        $populationSize = 150; 
        $generation = 500; 
        
        // ========== TAHAP 2: GENERATE POPULASI AWAL DENGAN ENHANCED CONSTRAINT-AWARE ========== 
        echo "\n=== TAHAP 2: PEMBENTUKAN POPULASI AWAL ENHANCED ===" . PHP_EOL; 
        $population = $this->generateEnhancedConstraintAwarePopulation($data, $populationSize, $rooms, $days, $slots, $constraintRuangan, $kelasData, $constraintDosen); 
        $this->displayInitialPopulation($population); 
        
        // ========== TAHAP 3: EVALUASI FITNESS ENHANCED ========== 
        echo "\n=== TAHAP 3: EVALUASI FITNESS POPULASI AWAL ENHANCED ===" . PHP_EOL; 
        $initialFitness = $this->evaluatePopulationEnhanced($population, $constraintRuangan, $constraintDosen, $kelasData, $rooms); 
        $this->displayFitnessEvaluation($population, $initialFitness); 
        
        $bestFitness = 0; 
        $stagnantCount = 0; 
        $adaptiveParams = $this->initializeAdaptiveParameters();
        
        echo "\n=== MENJALANKAN ENHANCED ALGORITMA GENETIKA ===" . PHP_EOL; 
        
        // Menjalankan algoritma genetika dengan adaptive parameters
        for ($i = 0; $i < $generation; $i++) { 
            $fitness = $this->evaluatePopulationEnhanced($population, $constraintRuangan, $constraintDosen, $kelasData, $rooms); 
            $currentBestFitness = max($fitness); 
            $averageFitness = array_sum($fitness) / count($fitness);
            
            if ($currentBestFitness > $bestFitness) { 
                $bestFitness = $currentBestFitness; 
                $stagnantCount = 0; 
            } else { 
                $stagnantCount++; 
            } 
            
            // Adaptive parameter adjustment
            $this->adjustAdaptiveParameters($adaptiveParams, $stagnantCount, $averageFitness, $bestFitness);
            
            // Early stopping dengan threshold yang lebih tinggi
            if ($stagnantCount > 50 && $bestFitness > 0.98) { 
                echo "Early stopping at generation " . ($i + 1) . " with fitness: " . number_format($bestFitness, 4) . PHP_EOL; 
                break; 
            } 
            
            // ========== TAHAP 4: ENHANCED ELITISM ========== 
            if ($i == 0) { 
                echo "\n=== TAHAP 4: PROSES ENHANCED ELITISM ===" . PHP_EOL; 
            } 
            $elites = $this->getEnhancedElites($population, $fitness, $this->elitismCount, $i == 0); 
            
            // ========== TAHAP 5: ADAPTIVE TOURNAMENT SELECTION ========== 
            if ($i == 0) { 
                echo "\n=== TAHAP 5: ADAPTIVE TOURNAMENT SELECTION ===" . PHP_EOL; 
            } 
            $selected = $this->adaptiveTournamentSelection($population, $fitness, $populationSize - $this->elitismCount, $adaptiveParams, $i == 0); 
            
            // ========== TAHAP 6: ENHANCED CONSTRAINT-AWARE CROSSOVER ========== 
            if ($i == 0) { 
                echo "\n=== TAHAP 6: ENHANCED CROSSOVER ===" . PHP_EOL; 
            } 
            $offspring = $this->enhancedConstraintAwareCrossover($selected, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData, $adaptiveParams, $i == 0); 
            
            // ========== TAHAP 7: ENHANCED INTELLIGENT MUTATION ========== 
            if ($i == 0) { 
                echo "\n=== TAHAP 7: ENHANCED MUTATION ===" . PHP_EOL; 
            } 
            $offspring = $this->enhancedIntelligentMutation($offspring, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData, $adaptiveParams, $i == 0); 
            
            // ========== TAHAP 8: CONSTRAINT REPAIR ========== 
            if ($i % 10 == 0) {
                $offspring = $this->performConstraintRepair($offspring, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData);
            }
            
            $population = array_merge($elites, $offspring); 
            
            if ($i % 10 == 0) { 
                echo "Generation " . ($i + 1) . " Best Fitness: " . number_format($bestFitness, 4) . 
                     " Avg Fitness: " . number_format($averageFitness, 4) . 
                     " Stagnant: $stagnantCount" . PHP_EOL; 
            } 
        } 
        
        // Dapatkan jadwal terbaik dan lakukan enhanced final repair
        $best = $this->getBestScheduleEnhanced($population, $constraintRuangan, $constraintDosen, $kelasData, $rooms); 
        $best = $this->enhancedFinalRepairSchedule($best, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData);
        
        // ========== ENHANCED ANALISIS KONFLIK JADWAL TERBAIK ========== 
        echo "\n=== ENHANCED ANALISIS KONFLIK JADWAL TERBAIK ===" . PHP_EOL; 
        $this->enhancedAnalyzeConflicts($best, $constraintRuangan, $constraintDosen, $kelasData, $rooms); 
        
        // Menyimpan jadwal terbaik ke database 
        $this->saveScheduleToDatabase($best, $timeSlots);
        
        $finalFitness = $this->evaluatePopulationEnhanced([$best], $constraintRuangan, $constraintDosen, $kelasData, $rooms); 
        $akurasi = $this->hitungEnhancedAkurasiJadwal($best, $constraintRuangan, $constraintDosen, $kelasData, $rooms); 
        
        echo "Enhanced Akurasi Jadwal: $akurasi%" . PHP_EOL; 
        
        $duration = round(microtime(true) - $start, 4); 
        
        echo "\n=== HASIL AKHIR ENHANCED GENETIC SCHEDULER ===" . PHP_EOL; 
        echo "Generasi : $generation" . PHP_EOL; 
        echo "Populasi awal : $populationSize" . PHP_EOL; 
        echo "Crossover Rate : " . ($this->crossoverRate * 100) . "%" . PHP_EOL; 
        echo "Mutation Rate : " . ($this->mutationRate * 100) . "%" . PHP_EOL; 
        echo "Elitism Count : " . $this->elitismCount . PHP_EOL; 
        echo "Fitness Terbaik : " . number_format($bestFitness, 4) . PHP_EOL; 
        echo "Enhanced Akurasi Jadwal : $akurasi%" . PHP_EOL; 
        echo "Durasi Waktu : $duration detik" . PHP_EOL; 
        
        return $best; 
    }

    private function initializeConstraintCaches($constraintRuangan, $constraintDosen, $rooms) {
    // Initialize available rooms cache
    $this->availableRoomsCache = [];
    foreach ($constraintRuangan as $constraint) {
    $kode_mk = $constraint['kode_mk'];
    $ruangan = $constraint['constraints_ruang'] ?? []; // Default empty array jika key tidak ada
    
    if (!isset($this->availableRoomsCache[$kode_mk])) {
        $this->availableRoomsCache[$kode_mk] = [];
    }
}
      
    // Initialize lecturer constraints cache
    $this->lecturerConstraintsCache = [];
    foreach ($constraintDosen as $constraint) {
        $dosen = $constraint['dosen'];
        $hari = $constraint['hari'];
        $jam = $constraint['jam_ke'];
        
        if (!isset($this->lecturerConstraintsCache[$dosen])) {
            $this->lecturerConstraintsCache[$dosen] = [];
        }
        
        // Create time key for constraint
        $timeKey = $hari . '_' . $jam;
        $this->lecturerConstraintsCache[$dosen][] = $timeKey;
    }
    
    // Initialize room type cache
    $this->roomTypeCache = [];
    foreach ($rooms as $room) {
        $this->roomTypeCache[$room['lokal']] = [
            'jenis' => $room['jenis_kelas'],
            'kapasitas' => $room['kapasitas'],
            'perkuliahan' => $room['perkuliahan'] ?? null
        ];
    }
    
    // Initialize room perkuliahan cache
    $this->roomPerkuliahanCache = [];
    foreach ($rooms as $room) {
        $this->roomPerkuliahanCache[$room['lokal']] = $room['perkuliahan'] ?? null;
    }
}
    /**
     * Initialize adaptive parameters for dynamic algorithm adjustment
     */
    private function initializeAdaptiveParameters() {
        return [
            'tournament_size' => 3,
            'crossover_rate' => $this->crossoverRate,
            'mutation_rate' => $this->mutationRate,
            'repair_frequency' => 10,
            'diversity_threshold' => 0.1
        ];
    }

    /**
     * Adjust adaptive parameters based on algorithm performance
     */
    private function adjustAdaptiveParameters(&$params, $stagnantCount, $averageFitness, $bestFitness) {
        // Increase exploration when stagnant
        if ($stagnantCount > 20) {
            $params['mutation_rate'] = min(0.4, $params['mutation_rate'] * 1.1);
            $params['crossover_rate'] = max(0.6, $params['crossover_rate'] * 0.95);
            $params['tournament_size'] = max(2, $params['tournament_size'] - 1);
        } else {
            // Exploit when improving
            $params['mutation_rate'] = max(0.1, $params['mutation_rate'] * 0.98);
            $params['crossover_rate'] = min(0.9, $params['crossover_rate'] * 1.02);
            $params['tournament_size'] = min(5, $params['tournament_size'] + 1);
        }
        
        // Adjust repair frequency based on fitness
        if ($averageFitness < 0.7) {
            $params['repair_frequency'] = 5; // More frequent repair
        } else {
            $params['repair_frequency'] = 15; // Less frequent repair
        }
    }

    /**
     * Generate enhanced population with better constraint awareness
     */
    private function generateEnhancedConstraintAwarePopulation($data, $populationSize, $rooms, $days, $slots, $constraintRuangan, $kelasData, $constraintDosen) {
        $population = [];
        
        // Generate diverse population with different strategies
        $strategies = ['constraint_first', 'capacity_first', 'random', 'lecturer_first'];
        
        for ($i = 0; $i < $populationSize; $i++) {
            $strategy = $strategies[$i % count($strategies)];
            $individual = $this->generateIndividualWithStrategy($data, $rooms, $days, $slots, $constraintRuangan, $kelasData, $constraintDosen, $strategy);
            $population[] = $individual;
        }
        
        return $population;
    }

    /**
     * Generate individual using specific strategy
     */
    private function generateIndividualWithStrategy($data, $rooms, $days, $slots, $constraintRuangan, $kelasData, $constraintDosen, $strategy) {
        $individual = [];
        $scheduleTracker = new EnhancedScheduleTracker();
        
        // Sort courses based on strategy
        $sortedCourses = $this->sortCoursesByStrategy($data, $constraintRuangan, $constraintDosen, $strategy);
        
        foreach ($sortedCourses as $course) {
            // Handle online courses
            if (isset($course['perkuliahan']) && $course['perkuliahan'] === 'DARING') {
                $assignment = $this->createOnlineAssignment($course, $days, $slots);
                $individual[] = $assignment;
                continue;
            }

            // Handle field courses
            if ($course['sks_teori'] == 0 && $course['sks_praktek'] == 0 && $course['sks_lapangan'] > 0) {
                $assignment = $this->createFieldAssignment($course);
                $individual[] = $assignment;
                continue;
            }

            $assignment = $this->findOptimalAssignment($course, $scheduleTracker, $rooms, $days, $slots, $constraintRuangan, $kelasData, $constraintDosen, $strategy);
            
            if ($assignment) {
                $individual[] = $assignment;
                $scheduleTracker->addAssignment($assignment);
            } else {
                // Enhanced fallback assignment
                $individual[] = $this->createEnhancedFallbackAssignment($course, $scheduleTracker, $rooms, $days, $slots);
            }
        }
        
        return $individual;
    }

    /**
     * Sort courses by different strategies
     */
    private function sortCoursesByStrategy($data, $constraintRuangan, $constraintDosen, $strategy) {
        $coursePriorities = [];
        $kelasData = Kelas::all(); 
        
        foreach ($data as $course) {
            $priority = 0;
            
            switch ($strategy) {
                case 'constraint_first':
                    // Prioritize courses with more constraints
                    if (isset($this->availableRoomsCache[$course['kode_mk']])) {
                        $priority += count($this->availableRoomsCache[$course['kode_mk']]) * 10;
                    }
                    if (isset($this->lecturerConstraintsCache[$course['dosen']])) {
                        $priority += count($this->lecturerConstraintsCache[$course['dosen']]) * 5;
                    }
                    if ($course['sks_praktek'] > 0) $priority += 15;
                    break;
                    
                case 'capacity_first':
                    // Prioritize courses with higher student count
                    $studentCount = $this->getStudentCount($course, $kelasData);
                    $priority += $studentCount;
                    break;
                    
                case 'lecturer_first':
                    // Prioritize courses by lecturer availability constraints
                    if (isset($this->lecturerConstraintsCache[$course['dosen']])) {
                        $priority += 20 - count($this->lecturerConstraintsCache[$course['dosen']]);
                    }
                    break;
                    
                case 'random':
                default:
                    $priority = rand(1, 100);
                    break;
            }
            
            $coursePriorities[] = ['course' => $course, 'priority' => $priority];
        }
        
        // Sort by priority (descending)
        usort($coursePriorities, function($a, $b) {
            return $b['priority'] - $a['priority'];
        });
        
        return array_column($coursePriorities, 'course');
    }

    /**
     * Find optimal assignment with enhanced constraint checking
     */
    private function findOptimalAssignment($course, $scheduleTracker, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData, $strategy) {
        $courseSlots = max(1, ceil(($course['sks_teori'] + $course['sks_praktek'] * 1.5)));
        $bestScore = -1;
        $bestAssignment = null;
        $attempts = 0;
        $maxAttempts = 100;
        
        // Get suitable rooms with enhanced filtering
        $suitableRooms = $this->getEnhancedSuitableRooms($course, $kelasData, $rooms, $strategy);
        
        foreach ($suitableRooms as $room) {
            foreach ($days as $day) {
                foreach ($slots as $slot) {
                    $attempts++;
                    if ($attempts > $maxAttempts) break 3; // Break all loops
                    
                    $jamNumeric = (int)$slot;
                    
                    // Check if course fits in time slots
                    if ($jamNumeric + $courseSlots - 1 > max($slots)) {
                        continue;
                    }
                    
                    $assignment = [
                        'course' => $course,
                        'room' => $room,
                        'time' => [
                            'hari' => $day,
                            'jam_ke' => $slot,
                            'waktu' => "$day - Jam ke-$slot"
                        ]
                    ];
                    
                    // Enhanced assignment scoring
                    $score = $this->evaluateEnhancedAssignment($assignment, $scheduleTracker, $constraintRuangan, $constraintDosen, $kelasData);
                    
                    if ($score > $bestScore) {
                        $bestScore = $score;
                        $bestAssignment = $assignment;
                    }
                    
                    // Early termination for excellent scores
                    if ($score >= 95) {
                        return $bestAssignment;
                    }
                }
            }
        }
        
        return $bestAssignment;
    }

// Add these methods to your GeneticScheduler class

/**
 * Fetch data from specified table
 */
private function fetchData($tableName) {
    try {
        $query = "SELECT * FROM $tableName";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error fetching data from $tableName: " . $e->getMessage() . PHP_EOL;
        return [];
    }
}

/**
 * Perform encoding of data
 */
private function performEncoding($data, $days, $slots, $rooms) {
    // Course encoding
    $this->courseEncoding = [];
    foreach ($data as $index => $course) {
        $this->courseEncoding[$course['kode_mk']] = $index;
    }
    
    // Day encoding
    $this->dayEncoding = [];
    foreach ($days as $id => $day) {
        $this->dayEncoding[$day] = $id;
    }
    
    // Slot encoding
    $this->slotEncoding = [];
    foreach ($slots as $id => $slot) {
        $this->slotEncoding[$slot] = $id;
    }
    
    // Room encoding
    $this->roomEncoding = [];
    foreach ($rooms as $index => $room) {
        $this->roomEncoding[$room['lokal']] = $index;
    }
    
    echo "Encoding completed:" . PHP_EOL;
    echo "- Courses: " . count($this->courseEncoding) . PHP_EOL;
    echo "- Days: " . count($this->dayEncoding) . PHP_EOL;
    echo "- Slots: " . count($this->slotEncoding) . PHP_EOL;
    echo "- Rooms: " . count($this->roomEncoding) . PHP_EOL;
}

/**
 * Display initial population
 */
private function displayInitialPopulation($population) {
    echo "Generated initial population with " . count($population) . " individuals" . PHP_EOL;
    if (!empty($population)) {
        echo "First individual has " . count($population[0]) . " course assignments" . PHP_EOL;
    }
}

/**
 * Display fitness evaluation
 */
private function displayFitnessEvaluation($population, $fitness) {
    $avgFitness = array_sum($fitness) / count($fitness);
    $maxFitness = max($fitness);
    $minFitness = min($fitness);
    
    echo "Initial population fitness:" . PHP_EOL;
    echo "- Average: " . number_format($avgFitness, 4) . PHP_EOL;
    echo "- Maximum: " . number_format($maxFitness, 4) . PHP_EOL;
    echo "- Minimum: " . number_format($minFitness, 4) . PHP_EOL;
}

/**
 * Enhanced analyze conflicts
 */
private function enhancedAnalyzeConflicts($schedule, $constraintRuangan, $constraintDosen, $kelasData, $rooms) {
    $conflicts = $this->detectScheduleConflicts($schedule);
    $roomConflicts = 0;
    $lecturerConflicts = 0;
    
    foreach ($conflicts as $conflict) {
        if ($conflict['type'] === 'room_conflict') {
            $roomConflicts++;
        } elseif ($conflict['type'] === 'lecturer_conflict') {
            $lecturerConflicts++;
        }
    }
    
    echo "Conflict Analysis:" . PHP_EOL;
    echo "- Room conflicts: $roomConflicts" . PHP_EOL;
    echo "- Lecturer conflicts: $lecturerConflicts" . PHP_EOL;
    echo "- Total conflicts: " . count($conflicts) . PHP_EOL;
    
    if (count($conflicts) == 0) {
        echo "✓ No conflicts detected!" . PHP_EOL;
    }
}

/**
 * Save schedule to database
 */
private function saveScheduleToDatabase($schedule, $timeSlots) {
    try {
        // Clear existing schedule
        $this->pdo->exec("TRUNCATE TABLE hasil_penjadwalan");
        
        foreach ($schedule as $assignment) {
            $course = $assignment['course'];
            $room = $assignment['room'];
            $time = $assignment['time'];
            
            // Skip special cases
            if ($room === 'ONLINE' || $room === 'LAPANGAN') {
                continue;
            }
            
            $stmt = $this->pdo->prepare("
                INSERT INTO hasil_penjadwalan 
                (kode_mk, nama_mk, dosen, ruangan, hari, jam_ke, waktu_mulai, waktu_selesai, sks_teori, sks_praktek, sks_lapangan, kode_seksi, prodi)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            // Find time slot details
            $jamKe = $time['jam_ke'];
            $waktuMulai = null;
            $waktuSelesai = null;
            
            foreach ($timeSlots as $timeSlot) {
                if ($timeSlot->jam_ke == $jamKe) {
                    $waktuMulai = $timeSlot->waktu_mulai;
                    $waktuSelesai = $timeSlot->waktu_selesai;
                    break;
                }
            }
            
            $stmt->execute([
                $course['kode_mk'],
                $course['nama_mk'],
                $course['dosen'],
                $room,
                $time['hari'],
                $jamKe,
                $waktuMulai,
                $waktuSelesai,
                $course['sks_teori'],
                $course['sks_praktek'],
                $course['sks_lapangan'],
                $course['kode_seksi'],
                $course['prodi']
            ]);
        }
        
        echo "Schedule saved to database successfully!" . PHP_EOL;
        
    } catch (PDOException $e) {
        echo "Error saving schedule: " . $e->getMessage() . PHP_EOL;
    }
}

/**
 * Calculate enhanced accuracy of schedule
 */
private function hitungEnhancedAkurasiJadwal($schedule, $constraintRuangan, $constraintDosen, $kelasData, $rooms) {
    $totalCourses = count($schedule);
    if ($totalCourses == 0) return 0;
    
    $conflicts = $this->detectScheduleConflicts($schedule);
    $conflictCount = count($conflicts);
    
    // Calculate accuracy based on conflicts
    $accuracy = max(0, (($totalCourses - $conflictCount) / $totalCourses) * 100);
    
    return number_format($accuracy, 2);
}


    /**
     * Enhanced suitable rooms selection with better filtering
     */
    private function getEnhancedSuitableRooms($course, $kelasData, $rooms, $strategy) {
        $kode_mk = $course['kode_mk'];
        $kode_seksi = $course['kode_seksi'] ?? null;
        $sks_praktek = $course['sks_praktek'];
        $coursePerkuliahan = $course['perkuliahan'] ?? null;
        
        $studentCount = $this->getStudentCount($course, $kelasData);
        $suitableRooms = [];
        
        // Strategy 1: Constraint-based rooms first
        if (isset($this->availableRoomsCache[$kode_mk])) {
            $constraintRooms = $this->availableRoomsCache[$kode_mk];
            
            foreach ($constraintRooms as $roomName) {
                $roomInfo = $this->roomTypeCache[$roomName] ?? null;
                if ($roomInfo && $this->isRoomSuitable($roomInfo, $course, $studentCount)) {
                    $suitableRooms[] = $roomName;
                }
            }
        }
        
        // Strategy 2: Add type-compatible rooms
        $requiredType = ($sks_praktek > 0) ? 'Praktek' : 'Teori';
        foreach ($rooms as $room) {
            if (in_array($room['lokal'], $suitableRooms)) continue;
            
            if ($this->isRoomSuitable($room, $course, $studentCount)) {
                $isTypeCompatible = $this->checkTypeCompatibility($room['jenis_kelas'], $requiredType);
                
                if ($isTypeCompatible) {
                    $suitableRooms[] = $room['lokal'];
                }
            }
        }
        
        // Strategy 3: Fallback to capacity-only matching
        if (empty($suitableRooms)) {
            foreach ($rooms as $room) {
                if ($room['kapasitas'] >= $studentCount) {
                    $suitableRooms[] = $room['lokal'];
                }
            }
        }
        
        // Shuffle for diversity unless using constraint_first strategy
        if ($strategy !== 'constraint_first') {
            shuffle($suitableRooms);
        }
        
        return $suitableRooms;
    }

    /**
     * Check if room is suitable for course
     */
    private function isRoomSuitable($room, $course, $studentCount) {
        // Check capacity
        if ($room['kapasitas'] < $studentCount) {
            return false;
        }
        
        // Check perkuliahan compatibility
        $coursePerkuliahan = $course['perkuliahan'] ?? null;
        $roomPerkuliahan = $room['perkuliahan'] ?? null;
        
        if ($coursePerkuliahan && $roomPerkuliahan && $coursePerkuliahan !== $roomPerkuliahan) {
            return false;
        }
        
        return true;
    }

    /**
     * Check type compatibility
     */
    private function checkTypeCompatibility($roomType, $requiredType) {
        if ($requiredType === 'Praktek') {
            return $roomType === 'Praktek';
        } else {
            return in_array($roomType, ['Teori', 'Praktek']);
        }
    }

    /**
     * Get student count for a course
     */
    private function getStudentCount($course, $kelasData) {
        $kode_seksi = $course['kode_seksi'] ?? null;
        if (!$kode_seksi) return 0;
        
        foreach ($kelasData as $kelas) {
            $kelasKodeSeksi = $kelas['kode_seksi'] ?? null;
            if ($kelasKodeSeksi === $kode_seksi) {
                return $kelas['jumlah_mhs'] ?? 0;
            }
        }
                
        return 0;
    }

    /**
     * Enhanced assignment evaluation with clear hard/soft constraint separation
     */
    private function evaluateEnhancedAssignment($assignment, $scheduleTracker, $constraintRuangan, $constraintDosen, $kelasData) {
        $score = 1000; // Start with high score
        $course = $assignment['course'];
        $room = $assignment['room'];
        $hari = $assignment['time']['hari'];
        $jam = (int)$assignment['time']['jam_ke'];
        $courseSlots = max(1, ceil(($course['sks_teori'] + $course['sks_praktek'] * 1.5)));

        // HARD CONSTRAINTS - Must be satisfied
        $hardPenalty = 0;
        
        for ($offset = 0; $offset < $courseSlots; $offset++) {
            $currentSlot = $jam + $offset;

            // Hard constraint: Room conflict
            if ($scheduleTracker->hasRoomConflict($room, $hari, $currentSlot)) {
                $hardPenalty += $this->HARD_ROOM_CONFLICT_PENALTY;
            }

            // Hard constraint: Lecturer conflict
            if ($scheduleTracker->hasLecturerConflict($course['dosen'], $hari, $currentSlot)) {
                $hardPenalty += $this->HARD_LECTURER_CONFLICT_PENALTY;
            }

            // Hard constraint: Group conflict
            if (!empty($course['group']) && $scheduleTracker->hasGroupConflict($course['group'], $hari, $currentSlot)) {
                $hardPenalty += $this->HARD_GROUP_CONFLICT_PENALTY;
            }
            
            // Hard constraint: Time slot overflow
            if ($currentSlot > max(array_keys($this->slotEncoding))) {
                $hardPenalty += $this->HARD_TIME_SLOT_OVERFLOW_PENALTY;
            }
        }

        // If hard constraints are violated, return very low score
        if ($hardPenalty > 0) {
            return max(0, $score - $hardPenalty);
        }

        // SOFT CONSTRAINTS - Preferred but can be violated
        $softPenalty = 0;

        // Soft constraint: Lecturer availability
        if (!$this->isLecturerAvailable($course['dosen'], $hari, $jam, $courseSlots)) {
            $softPenalty += $this->SOFT_LECTURER_AVAILABILITY_PENALTY;
        }

        // Soft constraint: Room capacity optimization
        $studentCount = $this->getStudentCount($course, $kelasData);
        $roomInfo = $this->roomTypeCache[$room] ?? null;
        if ($roomInfo) {
            $capacityRatio = $studentCount / $roomInfo['kapasitas'];
            if ($capacityRatio < 0.3) { // Room too big
                $softPenalty += $this->SOFT_ROOM_CAPACITY_PENALTY;
            }
        }

        // Soft constraint: Room type compatibility
        if ($roomInfo) {
            $requiredType = ($course['sks_praktek'] > 0) ? 'Praktek' : 'Teori';
            if ($requiredType === 'Praktek' && $roomInfo['jenis'] !== 'Praktek') {
                $softPenalty += $this->SOFT_ROOM_TYPE_MISMATCH_PENALTY;
            }
        }

        // Soft constraint: Perkuliahan compatibility
        $coursePerkuliahan = $course['perkuliahan'] ?? null;
        $roomPerkuliahan = $this->roomPerkuliahanCache[$room] ?? null;
        
        if ($coursePerkuliahan && $roomPerkuliahan && $coursePerkuliahan !== $roomPerkuliahan) {
            $softPenalty += $this->SOFT_PERKULIAHAN_MISMATCH_PENALTY;
        }

        // Soft constraint: Room preference (constraint-based rooms preferred)
        if (isset($this->availableRoomsCache[$course['kode_mk']])) {
            if (!in_array($room, $this->availableRoomsCache[$course['kode_mk']])) {
                $softPenalty += $this->SOFT_ROOM_PREFERENCE_PENALTY;
            }
        }

        // Soft constraint: Consecutive slots preference
        if ($courseSlots > 1) {
            $hasGap = false;
            for ($offset = 0; $offset < $courseSlots - 1; $offset++) {
                $currentSlot = $jam + $offset;
                $nextSlot = $jam + $offset + 1;
                if ($nextSlot - $currentSlot > 1) {
                    $hasGap = true;
                    break;
                }
            }
            if ($hasGap) {
                $softPenalty += $this->SOFT_CONSECUTIVE_SLOTS_PENALTY;
            }
        }

        return max(0, $score - $softPenalty);
    }

    /**
     * Enhanced population evaluation with detailed constraint analysis
     */
    private function evaluatePopulationEnhanced($population, $constraintRuangan, $constraintDosen, $kelasData, $rooms) {
        $fitness = [];
        
        foreach ($population as $individual) {
            $totalScore = 0;
            $maxScore = 0;
            $hardViolations = 0;
            $softViolations = 0;
            
            $scheduleTracker = new EnhancedScheduleTracker();
            
            foreach ($individual as $assignment) {
                $courseScore = $this->evaluateEnhancedAssignment($assignment, $scheduleTracker, $constraintRuangan, $constraintDosen, $kelasData);
                $totalScore += $courseScore;
                $maxScore += 1000; // Maximum possible score per course
                
                // Track violations for analysis
                if ($courseScore < 500) { // Likely hard constraint violation
                    $hardViolations++;
                } elseif ($courseScore < 900) { // Likely soft constraint violation
                    $softViolations++;
                }
                
                $scheduleTracker->addAssignment($assignment);
            }
            
            // Calculate fitness as percentage
            $individualFitness = ($maxScore > 0) ? ($totalScore / $maxScore) : 0;
            
            // Apply penalty for violations
            if ($hardViolations > 0) {
                $individualFitness *= (1 - ($hardViolations * 0.1)); // Heavy penalty for hard violations
            }
            if ($softViolations > 0) {
                $individualFitness *= (1 - ($softViolations * 0.02)); // Light penalty for soft violations
            }
            
            $fitness[] = max(0, $individualFitness);
        }
        
        return $fitness;
    }

    /**
     * Create online course assignment
     */
    private function createOnlineAssignment($course, $days, $slots) {
        return [
            'course' => $course,
            'room' => 'ONLINE',
            'time' => [
                'hari' => '-',
                'jam_ke' => '-',
                'waktu' => 'Online Learning'
            ]
        ];
    }

    /**
     * Create field course assignment
     */
    private function createFieldAssignment($course) {
        return [
            'course' => $course,
            'room' => 'LAPANGAN',
            'time' => [
                'hari' => '-',
                'jam_ke' => '-',
                'waktu' => 'Field Work'
            ]
        ];
    }

    /**
     * Enhanced fallback assignment creation
     */
    private function createEnhancedFallbackAssignment($course, $scheduleTracker, $rooms, $days, $slots) {
        // Find any available room with minimal conflicts
        $bestRoom = null;
        $bestDay = null;
        $bestSlot = null;
        $minConflicts = PHP_INT_MAX;
        
        foreach ($rooms as $room) {
            foreach ($days as $day) {
                foreach ($slots as $slot) {
                    $conflicts = 0;
                    
                    if ($scheduleTracker->hasRoomConflict($room['lokal'], $day, (int)$slot)) {
                        $conflicts++;
                    }
                    if ($scheduleTracker->hasLecturerConflict($course['dosen'], $day, (int)$slot)) {
                        $conflicts++;
                    }
                    
                    if ($conflicts < $minConflicts) {
                        $minConflicts = $conflicts;
                        $bestRoom = $room['lokal'];
                        $bestDay = $day;
                        $bestSlot = $slot;
                    }
                    
                    if ($conflicts == 0) break 3; // Found perfect assignment
                }
            }
        }
        
        return [
            'course' => $course,
            'room' => $bestRoom ?? $rooms[0]['lokal'],
            'time' => [
                'hari' => $bestDay ?? array_keys($days)[0],
                'jam_ke' => $bestSlot ?? array_keys($slots)[0],
                'waktu' => ($bestDay ?? array_keys($days)[0]) . " - Jam ke-" . ($bestSlot ?? array_keys($slots)[0])
            ]
        ];
    }

    /**
     * Check if lecturer is available
     */
    private function isLecturerAvailable($lecturerName, $day, $startSlot, $duration) {
        if (!isset($this->lecturerConstraintsCache[$lecturerName])) {
            return true; // No constraints means available
        }
        
        $constraints = $this->lecturerConstraintsCache[$lecturerName];
        
        for ($offset = 0; $offset < $duration; $offset++) {
            $currentSlot = $startSlot + $offset;
            $timeKey = $day . '_' . $currentSlot;
            
            if (in_array($timeKey, $constraints)) {
                return false; // Lecturer not available at this time
            }
        }
        
        return true;
    }

    /**
     * Get enhanced elites with diversity consideration
     */
    private function getEnhancedElites($population, $fitness, $eliteCount, $debug = false) {
        $elites = [];
        $fitnessWithIndex = [];
        
        // Create array with fitness and index
        for ($i = 0; $i < count($fitness); $i++) {
            $fitnessWithIndex[] = ['fitness' => $fitness[$i], 'index' => $i];
        }
        
        // Sort by fitness (descending)
        usort($fitnessWithIndex, function($a, $b) {
            return $b['fitness'] <=> $a['fitness'];
        });
        
        if ($debug) {
            echo "Selecting $eliteCount elites from population..." . PHP_EOL;
            echo "Top 5 fitness scores: ";
            for ($i = 0; $i < min(5, count($fitnessWithIndex)); $i++) {
                echo number_format($fitnessWithIndex[$i]['fitness'], 4) . " ";
            }
            echo PHP_EOL;
        }
        
        // Select top elites with diversity check
        $selectedIndices = [];
        $diversityThreshold = 0.1;
        
        for ($i = 0; $i < count($fitnessWithIndex) && count($elites) < $eliteCount; $i++) {
            $candidateIndex = $fitnessWithIndex[$i]['index'];
            $candidate = $population[$candidateIndex];
            
            // Check diversity
            $isDiverse = true;
            foreach ($selectedIndices as $selectedIndex) {
                $similarity = $this->calculateScheduleSimilarity($candidate, $population[$selectedIndex]);
                if ($similarity > (1 - $diversityThreshold)) {
                    $isDiverse = false;
                    break;
                }
            }
            
            if ($isDiverse || count($elites) < $eliteCount / 2) { // Allow some non-diverse if needed
                $elites[] = $candidate;
                $selectedIndices[] = $candidateIndex;
            }
        }
        
        // Fill remaining spots if needed
        while (count($elites) < $eliteCount && count($elites) < count($population)) {
            $randomIndex = rand(0, count($population) - 1);
            if (!in_array($randomIndex, $selectedIndices)) {
                $elites[] = $population[$randomIndex];
                $selectedIndices[] = $randomIndex;
            }
        }
        
        if ($debug) {
            echo "Selected " . count($elites) . " diverse elites" . PHP_EOL;
        }
        
        return $elites;
    }

    /**
     * Calculate similarity between two schedules
     */
    private function calculateScheduleSimilarity($schedule1, $schedule2) {
        if (count($schedule1) != count($schedule2)) {
            return 0;
        }
        
        $matches = 0;
        $total = count($schedule1);
        
        for ($i = 0; $i < $total; $i++) {
            if (isset($schedule1[$i]) && isset($schedule2[$i])) {
                $assignment1 = $schedule1[$i];
                $assignment2 = $schedule2[$i];
                
                if ($assignment1['room'] == $assignment2['room'] && 
                    $assignment1['time']['hari'] == $assignment2['time']['hari'] &&
                    $assignment1['time']['jam_ke'] == $assignment2['time']['jam_ke']) {
                    $matches++;
                }
            }
        }
        
        return $total > 0 ? $matches / $total : 0;
    }

    /**
     * Adaptive tournament selection with dynamic tournament size
     */
    private function adaptiveTournamentSelection($population, $fitness, $selectionCount, $adaptiveParams, $debug = false) {
        $selected = [];
        $tournamentSize = $adaptiveParams['tournament_size'];
        
        if ($debug) {
            echo "Tournament selection with size: $tournamentSize" . PHP_EOL;
        }
        
        for ($i = 0; $i < $selectionCount; $i++) {
            $tournament = [];
            $tournamentFitness = [];
            
            // Select random individuals for tournament
            for ($j = 0; $j < $tournamentSize; $j++) {
                $randomIndex = rand(0, count($population) - 1);
                $tournament[] = $population[$randomIndex];
                $tournamentFitness[] = $fitness[$randomIndex];
            }
            
            // Find best in tournament
            $bestIndex = 0;
            $bestFitness = $tournamentFitness[0];
            
            for ($k = 1; $k < count($tournamentFitness); $k++) {
                if ($tournamentFitness[$k] > $bestFitness) {
                    $bestFitness = $tournamentFitness[$k];
                    $bestIndex = $k;
                }
            }
            
            $selected[] = $tournament[$bestIndex];
        }
        
        if ($debug) {
            echo "Selected " . count($selected) . " individuals via tournament" . PHP_EOL;
        }
        
        return $selected;
    }

    /**
     * Enhanced constraint-aware crossover
     */
    private function enhancedConstraintAwareCrossover($parents, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData, $adaptiveParams, $debug = false) {
        $offspring = [];
        $crossoverRate = $adaptiveParams['crossover_rate'];
        
        if ($debug) {
            echo "Enhanced crossover with rate: " . ($crossoverRate * 100) . "%" . PHP_EOL;
        }
        
        for ($i = 0; $i < count($parents); $i += 2) {
            $parent1 = $parents[$i];
            $parent2 = isset($parents[$i + 1]) ? $parents[$i + 1] : $parents[0];
            
            if (rand(0, 100) / 100 < $crossoverRate) {
                // Perform enhanced crossover
                $children = $this->performEnhancedCrossover($parent1, $parent2, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData);
                $offspring[] = $children[0];
                if (count($offspring) < count($parents)) {
                    $offspring[] = $children[1];
                }
            } else {
                // Copy parents
                $offspring[] = $parent1;
                if (count($offspring) < count($parents)) {
                    $offspring[] = $parent2;
                }
            }
        }
        
        // Ensure we have the right number of offspring
        while (count($offspring) < count($parents)) {
            $offspring[] = $parents[rand(0, count($parents) - 1)];
        }
        
        if ($debug) {
            echo "Generated " . count($offspring) . " offspring from crossover" . PHP_EOL;
        }
        
        return array_slice($offspring, 0, count($parents));
    }

    /**
     * Perform enhanced crossover between two parents
     */
    private function performEnhancedCrossover($parent1, $parent2, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData) {
        $length = min(count($parent1), count($parent2));
        $child1 = [];
        $child2 = [];
        
        // Use order-based crossover with constraint repair
        $crossoverPoint1 = rand(0, $length - 1);
        $crossoverPoint2 = rand($crossoverPoint1, $length - 1);
        
        $tracker1 = new EnhancedScheduleTracker();
        $tracker2 = new EnhancedScheduleTracker();
        
        // Copy segments and repair conflicts
        for ($i = 0; $i < $length; $i++) {
            if ($i >= $crossoverPoint1 && $i <= $crossoverPoint2) {
                // Crossover segment - try parent2 assignment for child1
                $assignment1 = $this->repairAssignmentIfNeeded($parent2[$i], $tracker1, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData);
                $assignment2 = $this->repairAssignmentIfNeeded($parent1[$i], $tracker2, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData);
            } else {
                // Keep original segment
                $assignment1 = $this->repairAssignmentIfNeeded($parent1[$i], $tracker1, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData);
                $assignment2 = $this->repairAssignmentIfNeeded($parent2[$i], $tracker2, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData);
            }
            
            $child1[] = $assignment1;
            $child2[] = $assignment2;
            
            $tracker1->addAssignment($assignment1);
            $tracker2->addAssignment($assignment2);
        }
        
        return [$child1, $child2];
    }

    /**
     * Repair assignment if it causes conflicts
     */
    private function repairAssignmentIfNeeded($assignment, $tracker, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData) {
        $course = $assignment['course'];
        $room = $assignment['room'];
        $hari = $assignment['time']['hari'];
        $jam = (int)$assignment['time']['jam_ke'];
        
        // Handle special cases
        if ($room === 'ONLINE' || $room === 'LAPANGAN' || $hari === '-') {
            return $assignment;
        }
        
        $courseSlots = max(1, ceil(($course['sks_teori'] + $course['sks_praktek'] * 1.5)));
        
        // Check for conflicts
        $hasConflict = false;
        for ($offset = 0; $offset < $courseSlots; $offset++) {
            $currentSlot = $jam + $offset;
            
            if ($tracker->hasRoomConflict($room, $hari, $currentSlot) ||
                $tracker->hasLecturerConflict($course['dosen'], $hari, $currentSlot)) {
                $hasConflict = true;
                break;
            }
        }
        
        if (!$hasConflict) {
            return $assignment; // No repair needed
        }
        
        // Find alternative assignment
        $alternative = $this->findAlternativeAssignment($course, $tracker, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData);
        return $alternative ?: $assignment; // Return original if no alternative found
    }

    /**
     * Find alternative assignment for a course
     */
    private function findAlternativeAssignment($course, $tracker, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData) {
        $courseSlots = max(1, ceil(($course['sks_teori'] + $course['sks_praktek'] * 1.5)));
        $attempts = 0;
        $maxAttempts = 50;
        
        // Get suitable rooms
        $suitableRooms = $this->getEnhancedSuitableRooms($course, $kelasData, $rooms, 'random');
        
        foreach ($suitableRooms as $room) {
            foreach ($days as $day) {
                foreach ($slots as $slot) {
                    $attempts++;
                    if ($attempts > $maxAttempts) return null;
                    
                    $jamNumeric = (int)$slot;
                    
                    // Check if fits in time slots
                    if ($jamNumeric + $courseSlots - 1 > max($slots)) {
                        continue;
                    }
                    
                    // Check for conflicts
                    $hasConflict = false;
                    for ($offset = 0; $offset < $courseSlots; $offset++) {
                        $currentSlot = $jamNumeric + $offset;
                        
                        if ($tracker->hasRoomConflict($room, $day, $currentSlot) ||
                            $tracker->hasLecturerConflict($course['dosen'], $day, $currentSlot)) {
                            $hasConflict = true;
                            break;
                        }
                    }
                    
                    if (!$hasConflict) {
                        return [
                            'course' => $course,
                            'room' => $room,
                            'time' => [
                                'hari' => $day,
                                'jam_ke' => $slot,
                                'waktu' => "$day - Jam ke-$slot"
                            ]
                        ];
                    }
                }
            }
        }
        
        return null;
    }

    /**
     * Enhanced intelligent mutation
     */
    private function enhancedIntelligentMutation($population, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData, $adaptiveParams, $debug = false) {
        $mutationRate = $adaptiveParams['mutation_rate'];
        
        if ($debug) {
            echo "Enhanced mutation with rate: " . ($mutationRate * 100) . "%" . PHP_EOL;
        }
        
        $mutatedCount = 0;
        
        foreach ($population as &$individual) {
            if (rand(0, 100) / 100 < $mutationRate) {
                $this->performIntelligentMutation($individual, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData);
                $mutatedCount++;
            }
        }
        
        if ($debug) {
            echo "Mutated $mutatedCount individuals" . PHP_EOL;
        }
        
        return $population;
    }

    /**
     * Perform intelligent mutation on an individual
     */
    private function performIntelligentMutation(&$individual, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData) {
        if (empty($individual)) return;
        
        $mutationTypes = ['room', 'time', 'swap'];
        $mutationType = $mutationTypes[rand(0, count($mutationTypes) - 1)];
        
        $courseIndex = rand(0, count($individual) - 1);
        $assignment = &$individual[$courseIndex];
        
        // Skip special assignments
        if ($assignment['room'] === 'ONLINE' || $assignment['room'] === 'LAPANGAN') {
            return;
        }
        
        switch ($mutationType) {
            case 'room':
                $this->mutateRoom($assignment, $rooms, $kelasData);
                break;
            case 'time':
                $this->mutateTime($assignment, $days, $slots);
                break;
            case 'swap':
                $this->swapAssignments($individual, $courseIndex);
                break;
        }
    }

    /**
     * Mutate room assignment
     */
    private function mutateRoom(&$assignment, $rooms, $kelasData) {
        $course = $assignment['course'];
        $suitableRooms = $this->getEnhancedSuitableRooms($course, $kelasData, $rooms, 'random');
        
        if (!empty($suitableRooms)) {
            $newRoom = $suitableRooms[rand(0, count($suitableRooms) - 1)];
            $assignment['room'] = $newRoom;
        }
    }

    /**
     * Mutate time assignment
     */
    private function mutateTime(&$assignment, $days, $slots) {
        $newDay = array_keys($days)[rand(0, count($days) - 1)];
        $newSlot = array_keys($slots)[rand(0, count($slots) - 1)];
        
        $assignment['time'] = [
            'hari' => $newDay,
            'jam_ke' => $newSlot,
            'waktu' => "$newDay - Jam ke-$newSlot"
        ];
    }

    /**
     * Swap two assignments
     */
    private function swapAssignments(&$individual, $index1) {
        if (count($individual) < 2) return;
        
        $index2 = rand(0, count($individual) - 1);
        if ($index1 == $index2) return;
        
        // Swap room and time
        $temp = $individual[$index1]['room'];
        $individual[$index1]['room'] = $individual[$index2]['room'];
        $individual[$index2]['room'] = $temp;
        
        $temp = $individual[$index1]['time'];
        $individual[$index1]['time'] = $individual[$index2]['time'];
        $individual[$index2]['time'] = $temp;
    }

    /**
     * Perform constraint repair on population
     */
    private function performConstraintRepair($population, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData) {
        foreach ($population as &$individual) {
            $this->repairIndividualConstraints($individual, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData);
        }
        
        return $population;
    }

    /**
     * Repair constraints for an individual
     */
    private function repairIndividualConstraints(&$individual, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData) {
        $tracker = new EnhancedScheduleTracker();
        $repairedAssignments = [];
        
        foreach ($individual as $assignment) {
            $repairedAssignment = $this->repairAssignmentIfNeeded($assignment, $tracker, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData);
            $repairedAssignments[] = $repairedAssignment;
            $tracker->addAssignment($repairedAssignment);
        }
        
        $individual = $repairedAssignments;
    }

    /**
     * Get best schedule from population
     */
    private function getBestScheduleEnhanced($population, $constraintRuangan, $constraintDosen, $kelasData, $rooms) {
        $fitness = $this->evaluatePopulationEnhanced($population, $constraintRuangan, $constraintDosen, $kelasData, $rooms);
        
        $bestIndex = 0;
        $bestFitness = $fitness[0];
        
        for ($i = 1; $i < count($fitness); $i++) {
            if ($fitness[$i] > $bestFitness) {
                $bestFitness = $fitness[$i];
                $bestIndex = $i;
            }
        }
        
        return $population[$bestIndex];
    }

    /**
     * Enhanced final repair for best schedule
     */
    private function enhancedFinalRepairSchedule($schedule, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData) {
        $maxRepairAttempts = 3;
        
        for ($attempt = 0; $attempt < $maxRepairAttempts; $attempt++) {
            $conflicts = $this->detectScheduleConflicts($schedule);
            
            if (empty($conflicts)) {
                break; // No conflicts found
            }
            
            // Repair conflicts
            foreach ($conflicts as $conflict) {
                $this->repairSpecificConflict($schedule, $conflict, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData);
            }
        }
        
        return $schedule;
    }

    /**
     * Detect conflicts in schedule
     */
    private function detectScheduleConflicts($schedule) {
        $conflicts = [];
        $roomSchedule = [];
        $lecturerSchedule = [];
        
        foreach ($schedule as $index => $assignment) {
            $course = $assignment['course'];
            $room = $assignment['room'];
            $hari = $assignment['time']['hari'];
            $jam = (int)$assignment['time']['jam_ke'];
            
            // Skip special cases
            if ($room === 'ONLINE' || $room === 'LAPANGAN' || $hari === '-') {
                continue;
            }
            
            $courseSlots = max(1, ceil(($course['sks_teori'] + $course['sks_praktek'] * 1.5)));
            
            for ($offset = 0; $offset < $courseSlots; $offset++) {
                $currentSlot = $jam + $offset;
                $timeKey = $hari . '_' . $currentSlot;
                
                // Check room conflicts
                if (isset($roomSchedule[$room][$timeKey])) {
                    $conflicts[] = [
                        'type' => 'room_conflict',
                        'assignment_index' => $index,
                        'conflicting_index' => $roomSchedule[$room][$timeKey],
                        'room' => $room,
                        'time' => $timeKey
                    ];
                } else {
                    $roomSchedule[$room][$timeKey] = $index;
                }
                
                // Check lecturer conflicts
                $lecturer = $course['dosen'];
                if (isset($lecturerSchedule[$lecturer][$timeKey])) {
                    $conflicts[] = [
                        'type' => 'lecturer_conflict',
                        'assignment_index' => $index,
                        'conflicting_index' => $lecturerSchedule[$lecturer][$timeKey],
                        'lecturer' => $lecturer,
                        'time' => $timeKey
                    ];
                } else {
                    $lecturerSchedule[$lecturer][$timeKey] = $index;
                }
            }
        }
        
        return $conflicts;
    }

    /**
     * Repair specific conflict
     */
    private function repairSpecificConflict(&$schedule, $conflict, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData) {
        $assignmentIndex = $conflict['assignment_index'];
        
        if (!isset($schedule[$assignmentIndex])) {
            return;
        }
        
        $assignment = $schedule[$assignmentIndex];
        $course = $assignment['course'];
        
        // Create temporary tracker excluding current assignment
        $tracker = new EnhancedScheduleTracker();
        foreach ($schedule as $index => $otherAssignment) {
            if ($index != $assignmentIndex) {
                $tracker->addAssignment($otherAssignment);
            }
        }
        
        // Find new assignment
        $newAssignment = $this->findAlternativeAssignment($course, $tracker, $rooms, $days, $slots, $constraintRuangan, $constraintDosen, $kelasData);
        
        if ($newAssignment) {
            $schedule[$assignmentIndex] = $newAssignment;
        }
    }
}

/**
 * Enhanced Schedule Tracker for better conflict detection
 */
class EnhancedScheduleTracker {
    private $roomSchedule = [];
    private $lecturerSchedule = [];
    private $groupSchedule = [];
    
    public function addAssignment($assignment) {
        $course = $assignment['course'];
        $room = $assignment['room'];
        $hari = $assignment['time']['hari'];
        $jam = (int)$assignment['time']['jam_ke'];
        
        // Skip special cases
        if ($room === 'ONLINE' || $room === 'LAPANGAN' || $hari === '-') {
            return;
        }
        
        $courseSlots = max(1, ceil(($course['sks_teori'] + $course['sks_praktek'] * 1.5)));
        
        for ($offset = 0; $offset < $courseSlots; $offset++) {
            $currentSlot = $jam + $offset;
            $timeKey = $hari . '_' . $currentSlot;
            
            // Track room usage
            if (!isset($this->roomSchedule[$room])) {
                $this->roomSchedule[$room] = [];
            }
            $this->roomSchedule[$room][$timeKey] = true;
            
            // Track lecturer usage
            $lecturer = $course['dosen'];
            if (!isset($this->lecturerSchedule[$lecturer])) {
                $this->lecturerSchedule[$lecturer] = [];
            }
            $this->lecturerSchedule[$lecturer][$timeKey] = true;
            
            // Track group usage if applicable
            if (!empty($course['group'])) {
                $group = $course['group'];
                if (!isset($this->groupSchedule[$group])) {
                    $this->groupSchedule[$group] = [];
                }
                $this->groupSchedule[$group][$timeKey] = true;
            }
        }
    }
    
    public function hasRoomConflict($room, $day, $slot) {
        $timeKey = $day . '_' . $slot;
        return isset($this->roomSchedule[$room][$timeKey]);
    }
    
    public function hasLecturerConflict($lecturer, $day, $slot) {
        $timeKey = $day . '_' . $slot;
        return isset($this->lecturerSchedule[$lecturer][$timeKey]);
    }
    
    public function hasGroupConflict($group, $day, $slot) {
        $timeKey = $day . '_' . $slot;
        return isset($this->groupSchedule[$group][$timeKey]);
    }
}