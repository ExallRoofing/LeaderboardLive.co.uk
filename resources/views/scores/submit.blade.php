<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Submit Score for: {{ $competition->competition_name }}
        </h2>
    </x-slot>

    <div class="w-full min-h-screen px-4 pt-8 flex justify-center text-white" x-data="scoreCardSwipe()">
        <form method="POST" action="{{ route('scores.store', $entry->id) }}" enctype="multipart/form-data" class="w-full max-w-4xl space-y-6">
            @csrf

            <!-- Hole Card -->
            <template x-for="(hole, index) in holes" :key="index">
                <div x-show="currentHole === index" class="relative rounded-2xl p-6 shadow-2xl bg-white/10 border border-white/30 transition-all overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-4 bg-white/20 rounded overflow-hidden">
                        <div class="h-full bg-brandYellow-dark transition-all duration-300 rounded-md" :style="'width: ' + ((currentHole + 1) / holes.length * 100) + '%'"></div>
                    </div>

                    <div class="text-center mb-4 pt-4">
                        <h3 class="text-3xl font-bold text-brandGreen-dark">Hole <span x-text="index + 1"></span></h3>
                        <p class="text-sm text-brandGreen-light mt-1">Par <span x-text="hole.par"></span> • <span x-text="hole.yardage"></span> yds • SI <span x-text="hole.si"></span></p>
                    </div>

                    <div class="mt-6 text-center">
                        <p class="text-lg font-semibold mb-2">Your Score</p>
                        <div class="flex justify-center items-center space-x-4">
                            <button type="button" @click="decrementScore(index)" class="w-10 h-10 bg-brandYellow-dark text-brandGreen-dark text-xl rounded hover:bg-brandYellow-light">−</button>
                            <input type="number" min="1" max="15" class="w-18 text-center text-2xl font-bold rounded bg-white/80 text-brandGreen-dark" x-model="scores[index]" :name="'scores[' + index + ']'" required>
                            <button type="button" @click="incrementScore(index)" class="w-10 h-10 bg-brandYellow-dark text-brandGreen-dark text-xl rounded hover:bg-brandYellow-light">+</button>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-between">
                        <button type="button" @click="prevHole" x-show="index > 0" class="bg-white text-brandGreen-dark font-semibold px-4 py-2 rounded hover:bg-brandGreen-lightest">← Back</button>
                        <button type="button" @click="nextHole" x-show="index < 17" class="bg-white text-brandGreen-dark font-semibold px-4 py-2 rounded hover:bg-brandGreen-lightest">Next →</button>
                        <button type="button" @click="currentHole++" x-show="index === 17" class="bg-brandGreen-dark text-white px-6 py-2 rounded font-bold hover:bg-brandGreen-lightest">Review</button>
                    </div>
                </div>
            </template>

            <!-- Scorecard Review -->
            <div x-show="currentHole === 18" class="rounded-2xl p-6 shadow-2xl bg-white text-sm text-black max-w-6xl mx-auto">
                <h4 class="text-2xl font-bold text-center text-brandGreen-dark mb-6">Scorecard Review</h4>

                <div class="overflow-auto">
                    <table class="w-full table-auto border-collapse text-center">
                        <!-- FRONT 9 -->
                        <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="p-2">Hole</th>
                            <template x-for="i in 9">
                                <th class="p-2">H<span x-text="i"></span></th>
                            </template>
                            <th class="p-2 font-bold">OUT</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Yards -->
                        <tr>
                            <td class="p-2 font-semibold text-left">Yards</td>
                            <template x-for="i in 9">
                                <td class="p-2" x-text="holes[i - 1].yardage"></td>
                            </template>
                            <td class="p-2 font-semibold" x-text="sumYards(0, 9)"></td>
                        </tr>

                        <!-- Par -->
                        <tr>
                            <td class="p-2 font-semibold text-left">Par</td>
                            <template x-for="i in 9">
                                <td class="p-2" x-text="holes[i - 1].par"></td>
                            </template>
                            <td class="p-2 font-semibold" x-text="sumPar(0, 9)"></td>
                        </tr>

                        <!-- SI -->
                        <tr>
                            <td class="p-2 font-semibold text-left">SI</td>
                            <template x-for="i in 9">
                                <td class="p-2" x-text="holes[i - 1].si"></td>
                            </template>
                            <td class="p-2"></td>
                        </tr>

                        <!-- Score -->
                        <tr>
                            <td class="p-2 font-semibold text-left">Score</td>
                            <template x-for="i in 9">
                                <td class="p-2 text-center" :class="scoreClass(scores[i - 1], holes[i - 1].par)" x-text="scores[i - 1] || '-'"></td>
                            </template>
                            <td class="p-2 font-bold" x-text="sumScores(0, 9)"></td>
                        </tr>
                        </tbody>

                        <!-- BACK 9 -->
                        <thead>
                        <tr class="bg-gray-100 text-gray-700 mt-6">
                            <th class="p-2">Hole</th>
                            <template x-for="i in Array.from({length: 9}, (_, k) => k + 9)">
                                <th class="p-2">H<span x-text="i + 1"></span></th>
                            </template>
                            <th class="p-2 font-bold">IN</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Yards -->
                        <tr>
                            <td class="p-2 font-semibold text-left">Yards</td>
                            <template x-for="i in Array.from({length: 9}, (_, k) => k + 9)">
                                <td class="p-2" x-text="holes[i].yardage"></td>
                            </template>
                            <td class="p-2 font-semibold" x-text="sumYards(9, 18)"></td>
                        </tr>

                        <!-- Par -->
                        <tr>
                            <td class="p-2 font-semibold text-left">Par</td>
                            <template x-for="i in Array.from({length: 9}, (_, k) => k + 9)">
                                <td class="p-2" x-text="holes[i].par"></td>
                            </template>
                            <td class="p-2 font-semibold" x-text="sumPar(9, 18)"></td>
                        </tr>

                        <!-- SI -->
                        <tr>
                            <td class="p-2 font-semibold text-left">SI</td>
                            <template x-for="i in Array.from({length: 9}, (_, k) => k + 9)">
                                <td class="p-2" x-text="holes[i].si"></td>
                            </template>
                            <td class="p-2"></td>
                        </tr>

                        <!-- Score -->
                        <tr>
                            <td class="p-2 font-semibold text-left">Score</td>
                            <template x-for="i in Array.from({length: 9}, (_, k) => k + 9)">
                                <td class="p-2 text-center" :class="scoreClass(scores[i], holes[i].par)" x-text="scores[i] || '-'"></td>
                            </template>
                            <td class="p-2 font-bold" x-text="sumScores(9, 18)"></td>
                        </tr>

                        <!-- TOTAL -->
                        <tr class="font-bold bg-gray-200">
                            <td>Total</td>
                            <td colspan="9" class="text-right pr-4">TOTAL:</td>
                            <td x-text="sumScores(0, 18)"></td>
                        </tr>

                        <!-- Handicap -->
                        <tr class="font-semibold bg-gray-100">
                            <td>Handicap</td>
                            <td colspan="9"></td>
                            <td x-text="handicap"></td>
                        </tr>

                        <!-- Net Score -->
                        <tr class="font-bold bg-green-100 text-green-900">
                            <td>Net Score</td>
                            <td colspan="9"></td>
                            <td x-text="netScore()"></td>
                        </tr>

                        </tbody>
                    </table>
                </div>

                <div class="mt-6 text-center">
                    <button type="submit" class="bg-brandGreen-dark text-white font-bold px-6 py-3 rounded-full hover:bg-brandGreen-light">
                        Submit Final Score
                    </button>
                </div>
            </div>

        </form>
    </div>

    <script>
        function scoreCardSwipe() {
            return {
                currentHole: 0,
                scores: Array(18).fill(''),
                holes: @json($course->hole_data),
                handicap: {{ $entry->playing_handicap ?? 0 }},
                backNine: Array.from({length: 9}, (_, k) => k + 9),

                nextHole() {
                    if (this.currentHole < this.holes.length - 1) this.currentHole++;
                },
                prevHole() {
                    if (this.currentHole > 0) this.currentHole--;
                },
                incrementScore(i) {
                    if (!this.scores[i]) {
                        this.scores[i] = this.holes[i].par;
                    } else if (this.scores[i] < 15) {
                        this.scores[i]++;
                    }
                },
                decrementScore(i) {
                    if (!this.scores[i]) {
                        this.scores[i] = this.holes[i].par;
                    } else if (this.scores[i] > 1) {
                        this.scores[i]--;
                    }
                },
                sumScores(start, end) {
                    return this.scores
                        .slice(start, end)
                        .reduce((sum, val) => sum + (parseInt(val) || 0), 0);
                },
                sumPar(start, end) {
                    return this.holes
                        .slice(start, end)
                        .reduce((sum, h) => sum + (parseInt(h.par) || 0), 0);
                },
                sumYards(start, end) {
                    return this.holes
                        .slice(start, end)
                        .reduce((sum, h) => sum + (parseInt(h.yardage) || 0), 0);
                },
                scoreClass(score, par) {
                    score = parseInt(score);
                    par = parseInt(par);
                    if (!score || !par) return 'score-par';

                    if (score === par - 2) return 'score-eagle';
                    if (score === par - 1) return 'score-birdie';
                    if (score === par)     return 'score-par';
                    if (score === par + 1) return 'score-bogey';
                    if (score >= par + 2)  return 'score-double';

                    return 'score-par';
                },
                netScore() {
                    return this.sumScores(0, 18) - (parseInt(this.handicap) || 0);
                }
            }
        }
    </script>
</x-app-layout>
